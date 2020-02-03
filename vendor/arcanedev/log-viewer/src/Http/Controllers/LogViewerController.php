<?php namespace Arcanedev\LogViewer\Http\Controllers;

use Arcanedev\LogViewer\Exceptions\LogNotFoundException;
use Arcanedev\LogViewer\Tables\StatsTable;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Arcanedev\LogViewer\Helpers\LogParser;
use Illuminate\Pagination\Paginator;
use Log;
/**
 * Class     LogViewerController
 *
 * @package  LogViewer\Http\Controllers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class LogViewerController extends Controller
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var int */
    protected $perPage = 30;

    /** @var string */
    protected $showRoute = 'log-viewer::logs.show';

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * LogViewerController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->perPage = config('log-viewer.per-page', $this->perPage);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Show the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $stats     = $this->logViewer->statsTable();
        $chartData = $this->prepareChartData($stats);
        $percents  = $this->calcPercentages($stats->footer(), $stats->header());

        //return $this->view('dashboard', compact('chartData', 'percents'));
        return view('log.dashboard', compact('chartData', 'percents'));
    }

    /**
     * List all logs.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\View\View
     */
    public function listLogs(Request $request)
    {
        $stats   = $this->logViewer->statsTable();
        $headers = $stats->header();
        $rows    = $this->paginate($stats->rows(), $request);

        return view('log.logs', compact('headers', 'rows', 'footer'));
    }

    /**
     * Show the log.
     *
     * @param  string  $date
     *
     * @return \Illuminate\View\View
     */
    public function show(Request $request,$date)
    {
        $log = $this->getLogOrFail($date);
        if (!empty($request->timeStart) && !empty($request->timeEnd)) {
            $filterLog = $log->entries()->toArray();
            $level = $request['logLevel'];
            $timeStart = $date." ".$request->timeStart.":00";
            $timeEnd = $date." ".$request->timeEnd.":00";
            $timeStart = date('Y-m-d H:i:s',strtotime($timeStart . " -7 hour"));
            $timeEnd = date('Y-m-d H:i:s',strtotime($timeEnd . " -7 hour"));
            
            if ($level != "all") {
                $filterByTime = array_filter($filterLog,
                    function ($filterLog) use ($timeStart,$timeEnd,$level) {
                        return $filterLog['datetime'] >= $timeStart && $filterLog['datetime'] <= $timeEnd && $filterLog['level'] == $level;
                    }
                );
            } else {
                $filterByTime = array_filter($filterLog,
                    function ($filterLog) use ($timeStart,$timeEnd,$level) {
                        return $filterLog['datetime'] >= $timeStart && $filterLog['datetime'] <= $timeEnd;
                    }
                );
            }

            $entries = $this->paginateArray($filterByTime,$this->perPage);
        } else {
            $levels  = $this->logViewer->levelsNames();
            $logArray = $log->entries()->toArray();
            $entries = $this->paginateArray($logArray,$this->perPage);
   
        }
   
        return view('log.show', compact('log', 'levels', 'entries','date'));
    }

	public function paginateArray($items,$perPage)
	{
		if(empty($items)) {
			$items = [];
		}

		$pageStart = \Request::get('page', 1);
		// Start displaying items from this number;
		$offSet = ($pageStart * $perPage) - $perPage; 

		// Get only the items you need using array_slice
        $itemsForCurrentPage = array_slice($items, $offSet, $perPage, true);
		return new LengthAwarePaginator($itemsForCurrentPage, count($items), $perPage,Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath()));
	}

    /**
     * Filter the log entries by level.
     *
     * @param  string  $date
     * @param  string  $level
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showByLevel($date, $level)
    {
        $log = $this->getLogOrFail($date);

        if ($level === 'all')
            return redirect()->route($this->showRoute, [$date]);

        $levels  = $this->logViewer->levelsNames();
        $entriesArray = $this->logViewer
            ->entries($date, $level)->toArray();
        $entries = $this->paginateArray($entriesArray,$this->perPage);
 
        return view('log.show', compact('log', 'levels', 'entries','date'));
    }

    /**
     * Download the log
     *
     * @param  string  $date
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($date)
    {
        return $this->logViewer->download($date);
    }

    /**
     * Delete a log.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        if ( ! $request->ajax())
            abort(405, 'Method Not Allowed');

        $date = $request->get('date');

        return response()->json([
            'result' => $this->logViewer->delete($date) ? 'success' : 'error'
        ]);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Paginate logs.
     *
     * @param  array                     $data
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function paginate(array $data, Request $request)
    {
        $page   = $request->get('page', 1);
        $offset = ($page * $this->perPage) - $this->perPage;
        $items  = array_slice($data, $offset, $this->perPage, true);
        $rows   = new LengthAwarePaginator($items, count($data), $this->perPage, $page);

        $rows->setPath($request->url());

        return $rows;
    }

    /**
     * Get a log or fail
     *
     * @param  string  $date
     *
     * @return \Arcanedev\LogViewer\Entities\Log|null
     */
    protected function getLogOrFail($date)
    {
        $log = null;

        try {
            $log = $this->logViewer->get($date);
        }
        catch (LogNotFoundException $e) {
            abort(404, $e->getMessage());
        }

        return $log;
    }

    /**
     * Prepare chart data.
     *
     * @param  \Arcanedev\LogViewer\Tables\StatsTable  $stats
     *
     * @return string
     */
    protected function prepareChartData(StatsTable $stats)
    {
        $totals = $stats->totals()->all();

        return json_encode([
            'labels'   => Arr::pluck($totals, 'label'),
            'datasets' => [
                [
                    'data'                 => Arr::pluck($totals, 'value'),
                    'backgroundColor'      => Arr::pluck($totals, 'color'),
                    'hoverBackgroundColor' => Arr::pluck($totals, 'highlight'),
                ],
            ],
        ]);
    }

    /**
     * Calculate the percentage.
     *
     * @param  array  $total
     * @param  array  $names
     *
     * @return array
     */
    protected function calcPercentages(array $total, array $names)
    {
        $percents = [];
        $all      = Arr::get($total, 'all');

        foreach ($total as $level => $count) {
            $percents[$level] = [
                'name'    => $names[$level],
                'count'   => $count,
                'percent' => $all ? round(($count / $all) * 100, 2) : 0,
            ];
        }

        return $percents;
    }
}
