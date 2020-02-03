@extends('theme')
@section('content')
<style>
.loader {
    background-position-y: center;
    border: 6px solid #f3f3f3; /* Light grey */
    border-top: 6px solid #99CCFF; /* Blue */
    border-radius: 50%;
    width: 60px;
    height: 60px;
    animation: spin 1s linear infinite;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<!-- Modal -->
<div style="width:100%;" id="modalShowData" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div id="modalBody" class="modal-content">
        
    </div>
  </div>
</div>
    <section class="vbox">
        <section class="scrollable padder">
            <div class="m-b-md">
                <div class="row">
                <div class="col-sm-6">
                    <h3 class="m-b-none"><strong>ภาพรวม SS - PRODUCTION</strong></h3>
                    <small>Statistics & graph information</small>
                </div>
                <div class="col-sm-6">
                    <div class="text-right text-left-xs">
                        <div class="sparkline m-l m-r-lg pull-right" data-type="bar" data-height="35" data-bar-width="6" data-bar-spacing="2" data-bar-color="#fb6b5b">5,8,9,12,8,10,8,9,7,8,6</div>
                            <div class="m-t-md">
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-b-lg">
                <div class="col-sm-9">
                  <a href="#" id="USERS" class="btn btn-sm btn-default btn-rounded m-b-xs" data-toggle="modal" data-target="#modalShowData"><i class="fa fa-user icon"></i> USERS</a>
                  <a href="#" id="GROUPS" class="btn btn-sm btn-default btn-rounded m-b-xs" data-toggle="modal" data-target="#modalShowData"><i class="fa fa-group icon"></i> GROUPS</a>
                  <a href="#" id="FORMS" class="btn btn-sm btn-default btn-rounded m-b-xs" data-toggle="modal" data-target="#modalShowData"><i class="fa fa-list-ul icon"></i> FORMS</a>
                  <a href="#" id="MASTER LISTS" class="btn btn-sm btn-default btn-rounded m-b-xs" data-toggle="modal" data-target="#modalShowData"><i class="fa fa-list-alt icon"></i> MASTER LISTS</a>
                  <a href="#" id="MASTER DATA" class="btn btn-sm btn-default btn-rounded m-b-xs" data-toggle="modal" data-target="#modalShowData"><i class="i i-data2 icon"></i> MASTER DATA</a>
                </div>
            </div>
            <section class="panel panel-default">
                <header class="panel-heading font-bold">จำนวนทั้งหมด</header>
                <footer id="showDataCount" class="panel-footer bg-white">
                    <center><div id="loadDataCount" class="loader"></div></center>
                </footer>
            </section>
            <section class="panel panel-danger">
                <header class="panel-heading font-bold">จำนวนที่ถูกลบ</header>
                <footer id="showDataDelete" class="panel-footer bg-white">
                    <center><div id="loadDataDelete" class="loader"></div></center>
                </footer>
            </section>
        </div>
        </section>
    </section>
    <script rel="javascript" type="text/javascript" src="{{asset('js/statistic.js')}}"></script>
@endsection