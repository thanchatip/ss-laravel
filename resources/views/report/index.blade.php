@extends('theme')
@section('content')
<style type="text/css">
/*.i-file-excel {
  color: #99FF99;
}*/
</style>
<section class="vbox bg-white">
    <section class="scrollable padder">
        <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <a class="btn btn-default" href="{{ route('forms.index') }}">
                    <i class="fa fa-backward"></i> กลับ</a>
                </div>
                <div class="pull-left">
                    <h2>{{ $form['data']['title'] }}</h2>
                    <a href="{{ route('forms.index') }}"><u>ALL FORMS</u></a> > {{ $form['data']['title'] }}
                </div>
            </div>
        </div>
        <hr>
        <div class="row m-t">
            <div class="col-md-12">
                <div class="doc-buttons">
                    <a href="{{ route('forms.show',$form['data']['objectId']) }}" class="btn btn-s-xl btn-default">รายละเอียดฟอร์ม</a>  
                    <a href="{{ URL('answerForms',$form['data']['objectId']) }}" class="btn btn-s-xl btn-default">คำตอบทั้งหมด</a>
                    <a href="#" class="btn btn-s-xl btn-primary disabled">รายงาน</a>               
                </div> 
            </div>
        </div> 
        <div class="blog-post">
            <div class="post-item">
                <div class="caption wrapper-lg">
                    <h2 class="post-title"><strong>RAW DATA</strong></h2>
                    <div class="post-sum">
                        <p>ข้อมูลดิบที่สุด ถูกแสดงในรูปของ Excel หรือ CSV เหมาะแก่การนำข้อมูลไปใช้โดยที่ข้อมูลยังไม่ถูกนำไปประมวลผลใดๆ</p>
                    </div>
                    <div class="text-muted" style="text-align:right;">
                        <a href="{{ config('app.ss_report') }}/autoExcelLv1/{{$form['data']['objectId']}}?userId={{$userId}}&type=csv" class="btn btn-s-sm btn-default">
                            <i class="i i-file"></i> CSV
                        </a>
                        <a href="{{ config('app.ss_report') }}/autoExcelLv1/{{$form['data']['objectId']}}?userId={{$userId}}&type=xlsx" class="btn btn-s-sm btn-default">
                            <i class="i i-file-excel"></i> EXCEL
                        </a>          
                    </div>
                </div>
            </div> 
            <div class="post-item">
                <div class="caption wrapper-lg">
                    <div class="pull-right">
                        @if ($rolesCode == 'admin' || $rolesCode['questionFormRoleCode'] == '0' || $rolesCode['answerFormRoleCode'] == '2')
                            <a href="{{ URL('report/customtable',$form['data']['objectId']) }}" class="btn btn-s-sm btn-default"><i class="i i-settings"></i> ตั้งค่า</a> 
                        @else
                            <a href="#" class="btn btn-s-sm btn-default" disabled><i class="i i-settings"></i> ตั้งค่า</a>  
                        @endif      
                    </div>
                    <h2 class="post-title"><strong>CUSTOM TABLE</strong></h2>
                    <div class="post-sum">
                        <p>ข้อมูลดิบคล้ายกับ RAW DATA ที่สามารถกำหนดได้ว่าจะให้มีกี่ sheet และแต่ละ sheet มี column ไหนบ้าง เพื่อลดความซับซ้อนของข้อมูลก่อนนำไปใช้งาน</p>
                    </div>
                    <div class="text-muted" style="text-align:right;">
                        @if ($rolesCode == 'admin' || $rolesCode['questionFormRoleCode'] == '0' || $rolesCode['answerFormRoleCode'] == '2')
                        <a href="{{ config('app.ss_report') }}/customtable/{{$form['data']['objectId']}}?userId={{$userId}}&type=csv" class="btn btn-s-sm btn-default"><i class="i i-file"></i> CSV</a>
                        <a href="{{ config('app.ss_report') }}/customtable/{{$form['data']['objectId']}}?userId={{$userId}}&type=xlsx" class="btn btn-s-sm btn-default"><i class="i i-file-excel"></i> EXCEL</a>     
                        @else
                        <a href="#" class="btn btn-s-sm btn-default" disabled><i class="i i-file"></i> CSV</a>
                        <a href="#" class="btn btn-s-sm btn-default" disabled><i class="i i-file-excel"></i> EXCEL</a>    
                        @endif 
      
                    </div>
                </div>
            </div>
            <div class="post-item">
                <div class="caption wrapper-lg">
                    <div class="pull-right">
                        @if ($rolesCode == 'admin' || $rolesCode['questionFormRoleCode'] == '0' || $rolesCode['answerFormRoleCode'] == '2')
                            <a href="{{ URL('report/basicreport',$form['data']['objectId']) }}" class="btn btn-s-sm btn-default"><i class="i i-settings"></i> ตั้งค่า</a> 
                        @else
                            <a href="#" class="btn btn-s-sm btn-default" disabled><i class="i i-settings"></i> ตั้งค่า</a>  
                        @endif      
                    </div>
                    <h2 class="post-title"><strong>BASIC REPORT</strong></h2>
                    <div class="post-sum">
                        <p>สรุปข้อมูลอย่างง่ายแบบอัตโนมัติตามชนิดของคำถามแต่ละข้อ เช่น การหาเปอร์เซ็นต์ ผลรวม ค่าเฉลี่ย และค่าต่ำสุด สูงสุด</p>
                    </div>
                    <div class="text-muted" style="text-align:right;">
                        @if ($rolesCode == 'admin' || $rolesCode['questionFormRoleCode'] == '0' || $rolesCode['answerFormRoleCode'] == '2')
                        <a href="#" class="btn btn-s-sm btn-default"><i class="i i-file"></i> CSV</a>
                        <a href="#" class="btn btn-s-sm btn-default"><i class="i i-file-excel"></i> EXCEL</a>     
                        @else
                        <a href="#" class="btn btn-s-sm btn-default" disabled><i class="i i-file"></i> CSV</a>
                        <a href="#" class="btn btn-s-sm btn-default" disabled><i class="i i-file-excel"></i> EXCEL</a>    
                        @endif         
                    </div>
                </div>
            </div>
            <div class="post-item">
                <div class="caption wrapper-lg">
                    <div class="pull-right">
                        <a href="#" class="btn btn-s-sm btn-default" disabled><i class="i i-settings"></i> ตั้งค่า</a>       
                    </div>
                    <h2 class="post-title"><strong>AGGREGATION</strong></h2>
                    <div class="post-sum">
                        <p>จัดกลุ่มของข้อมูล และคำนวณหาตัวแทนของกลุ่มเหล่านั้นผ่านฟังก์ชันที่จัดเตรียมไว้ให้</p>
                    </div>
                    <div class="text-muted" style="text-align:right;">
                        <a href="#" class="btn btn-s-sm btn-default" disabled><i class="i i-file"></i> CSV</a>
                        <a href="#" class="btn btn-s-sm btn-default" disabled><i class="i i-file-excel"></i> EXCEL</a>          
                    </div>
                </div>
            </div>
            <div class="post-item">
                <div class="caption wrapper-lg">
                    <div class="pull-right">
                        @if ($rolesCode == 'admin')
                            <a href="#" class="btn btn-s-sm btn-default"><i class="i i-settings"></i> ตั้งค่า</a> 
                        @else
                            <a href="#" class="btn btn-s-sm btn-default" disabled><i class="i i-settings"></i> ตั้งค่า</a>  
                        @endif      
                    </div>
                    <h2 class="post-title"><strong>CUSTOM REPORT</strong></h2>
                    <div class="post-sum">
                        <p>หาต้องการรายงานในแบบที่ต้องการ <a href="#"><u>กรุณาติดต่อทีมงาน</u></a></p>
                    </div>
                    @php ($formId = $form['data']['objectId'])
                    <div class="text-muted" style="text-align:right;">
                        @if (in_array($form['data']['objectId'],$reportLists) == true) 
                        @php ($reportName = array_search($form['data']['objectId'],$reportLists))
                            <a href="{{ URL("report/$reportName/index") }}" class="btn btn-s-sm btn-default">REPORT <i class="i i-arrow-right"></i></a> 
                        @elseif (
                            $form['data']['objectId'] == '20180815074404-55601184433949-1329190' ||
                            $form['data']['objectId'] == '20180907082343-558001423121236-1842136' ||
                            $form['data']['objectId'] == '20181009031557-560747757666275-1177697'
                        )
                        <a href="{{ URL("report/coffee/index",[$formId]) }}" class="btn btn-s-sm btn-default">REPORT <i class="i i-arrow-right"></i></a>
                        @else
                            <a href="#" class="btn btn-s-sm btn-default" disabled>REPORT <i class="i i-arrow-right"></i></a> 
                        @endif
                    </div>
                </div>
            </div>
        </div>     
    </section>
 </section>
</section>
@endsection