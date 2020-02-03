<!DOCTYPE html>
<html lang="en" class="app">
<head>  
  <meta charset="utf-8" />
  <title>MFLF | Documents</title>
  <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="{{asset('theme/css/bootstrap.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('theme/css/animate.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('theme/css/font-awesome.min.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('theme/css/icon.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('theme/css/font.css')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('theme/css/app.css')}}" type="text/css" />
    <!--[if lt IE 9]>
    <script src="js/ie/html5shiv.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="js/ie/excanvas.js"></script>
  <![endif]-->
</head>
<body class="">
    <section class="hbox stretch">
    <!-- .aside -->
    <aside class="bg-light aside b-r animated fadeInLeftBig">
      <section class="vbox">
        <header class="header b-b navbar">
          <a class="btn btn-link pull-right visible-xs" data-toggle="class:show" data-target=".nav-primary">
            <i class="fa fa-bars"></i>
          </a>
          <a href="#" class="navbar-brand">ImportData Documents</a>
        </header>
        <section class="scrollable">
          <nav class="nav-primary hidden-xs nav-docs">
            <ul class="nav">
              <li class="dropdown-header b-b b-light"><em>Template</em></li>
              <li><a href="#downloadtemplate">Download Template</a></li>
              <li><a href="#typetemplate">รูปแบบ Template</a></li>
              <li><a href="#useTemplate">การใช้งาน Template</a></li>    
              <li class="dropdown-header"><a href="#typeChoice"> - คำถาม Type Choice</a></li>  
              <li class="dropdown-header"><a href="#typeInnerForm"> - คำถาม Type InnerForm</a></li>
              <li class="dropdown-header"><a href="#typeLatLong"> - คำถาม Type LatLong</a></li>                
              <li class="dropdown-header"><em>Import</em></li>
              <li><a href="#importData">Import ข้อมูล</a></li>
              <!--<li><a href="#validateData">แจ้งเตือน Import ข้อมูล</a></li>-->
            </ul>
          </nav>
        </section>
      </section>
    </aside>
    <!-- /.aside -->
    <section id="content">
      <section class="vbox">
        <section class="scrollable bg-light lter" data-spy="scroll" data-target=".nav-primary">
          <section  id="docs">
            <div class="clearfix padder">
              <h4><b>ภาพรวม</b></h4>
              <ul>
                <li>Download Template</li>
                <li>รูปแบบ Template ที่ใช้ในการ Import ข้อมูล</li>
                <li>การวางข้อมูลให้ถูกต้องตาม Template</li>
                <li>การ Import ข้อมูล</li>
                <!--<li>ข้อความแจ้งเตือนหลัง Import ข้อมูล</li> -->
              </ul>

              <h3 id="downloadtemplate" class="text-success">Download Template<small> </small></h3>
              <p>สามารถดาวโหลดไฟล์ Template ได้ที่ <strong><a target="_blank" href="{{ URL::to('/import/data/index') }}">Import Data</a></strong></p>
              <p><code>1.</code> เมื่อเข้าไปที่ <strong><a target="_blank" href="{{ URL::to('/import/data/index') }}">Import Data</a></strong> จะเห็นช่อง <strong>Download Template</strong> จะมีให้เลือกโหลด Template Form และ ตัวเลือก Choice ของคำถามที่เป็นคำถามประเภท Choice ในแต่ละ Form </p>
              <p><code>*</code> ตัวเลือก Choice ใช้ในการนำคำตอบของคำถามประเภท Choice ไปเป็นคำตอบใน Template Form</p>
              <div class="panel shift b-light" data-toggle="shift:insertBefore" data-target="#shift-target">
                <div class="panel-body">
                  <img src="{{asset('theme/importdata/downloadtemplate.png')}}" class="m-r-sm" alt="scale">
                </div>
              </div>
              
              <p><code>2.</code> จะมีให้โหลด Choice และ Template ของ Form</p>
              <p><code>3.</code> เลือก Template ของ Form ที่ต้องการ Download และกด Download จะได้ไฟล์ .xlsx มา</p>
              <h3 id="typetemplate" class="text-success">รูปแบบ Template ที่ใช้ในการ Import ข้อมูล<small> </small></h3>
              <p> - rows 1 ใน column แรก จะเป็น FormId และ หลังจาก column แรกไปจะเป็น <code>คำถามที่อยู่ใน Form</code> นั้นทั้งหมด</p>
              <p> - Type หลังชื่อคำถาม หลังชื่อคำถามจะมีบอกว่าคำนั้นๆ เป็น <code>คำถามประเภท Type</code> ไหน</p>
              <div class="panel shift b-light" data-toggle="shift:insertBefore" data-target="#shift-target">
                <div class="panel-body">
                  <img src="{{asset('theme/importdata/headerTemplate.png')}}" width="100%" height="100%" class="m-r-sm" alt="scale">
                </div>
              </div>
              
              <p> - column สุดท้ายของ rows ที่ 1 จะชื่อ column <code>"ผู้บันทึก"</code> จะเอาไว้ใส่รหัสพนักพนักงานที่เป็นคนตอบคำถามนั้นๆ</p>
              <div class="panel shift b-light" data-toggle="shift:insertBefore" data-target="#shift-target">
                <div class="panel-body">
                  <img src="{{asset('theme/importdata/createdBy.png')}}" class="m-r-sm" alt="scale">
                </div>
              </div>
              <p> - sheet แรกของ Template Form จะเป็น <code>Main Form</code> และหลังจาก sheet แรกไปจะเป็น <code>inner Form</code> ทั้งหมดของ Main Form </p>
              <p> - <code>ลำดับ sheet</code> ของ Template Form จะเรียงตาม <code>Lv ของ Inner Form</code>
              <div class="panel shift b-light" data-toggle="shift:insertBefore" data-target="#shift-target">
                <div class="panel-body">
                  <img src="{{asset('theme/importdata/sheet.png')}}" class="m-r-sm" alt="scale">
                </div>
              </div>
              <h3 id="useTemplate" class="text-success">การใช้งาน Template<small> </small></h3>
              <p>สามารถ Import ข้อมูลได้ที่ <strong><a target="_blank" href="{{ URL::to('/import/data/index') }}">Import Data</a></strong></p>
              <p><code>1.</code> การวางข้อมูลใน Template เพื่อ Import ข้อมูลเข้าไปในระบบ</p>
              <p> - 1 AnswerForm จะเท่ากับ 1 rows ของ Excel</p>
              <p> - การใส่ answer จะต้องวาง answer ให้ตรงกับ column ของ question ที่ต้องการจะใส่</p>
              <div class="panel shift b-light" data-toggle="shift:insertBefore" data-target="#shift-target">
                <div class="panel-body">
                  <img src="{{asset('theme/importdata/rowsAnswerForm.png')}}" width="100%" height="100%" class="m-r-sm" alt="scale">
                </div>
              </div>
              <p> - <code>กรณีต้องการใส่ answer มากกว่า 1 answer</code> สามารถใส่ได้โดยการคั้นด้วย <code>"," ตามภาพตัวอย่างด้านล่าง </code></p>
              <div class="panel shift b-light" data-toggle="shift:insertBefore" data-target="#shift-target">
                <div class="panel-body">
                  <img src="{{asset('theme/importdata/2answer.png')}}" width="100%" height="100%" class="m-r-sm" alt="scale">
                </div>
              </div>
              <p> - การใส่ชื่อผู้บันทึกคำตอบหรือ <code>createdBy</code> ให้ใส่เป็น <code>รหัสพนักงานเท่านั้น</code> และต้องใส่ในช่อง column <code>ผู้บันทึก</code> ซึ่งจะอยู่ column สุดท้ายของ Template Form</p>
              <h4 class="text-danger">* ทุกประเภท type คำถามสามารถใส่คำตอบอะไรก็ได้ที่ต้องการใส่ลงไป ยกเว้น Type </h4>
              <table class="table table-border">
                <tbody>
                  <tr class="bg-light">
                    <td>Type Name</td>
                    <td>Type Number</td>
                  </tr>
                  <tr>
                    <td>Choice</td>
                    <td>2,3,12,15</td>
                  </tr>
                  <tr>
                    <td>InnerForm</td>
                    <td>7</td>
                  </tr>
                  <tr>
                    <td>Latitude Longtitude</td>
                    <td>16</td>
                  </tr>
                </tbody>
              </table>
              <h3  id="typeChoice" class="text-success">การใส่คำตอบในคำถามประเภท Type Choice</h3>
              <p><code>*</code> Type ที่ 2,3,12,15 คือ Type ที่มี Choice</p>
              <p><code>*</code> ก่อนที่จะใส่คำตอบของคำถามประเภท Choice ควรที่จะโหลด Choice ของ Form นั้นมาดูควบคู่เพื่อที่จะได้ใส่คำตอบของ Choice นั้นได้ถูกต้อง</p>
              <p><code>*</code> จำเป็นต้อง ใส่คำให้ตรงกับ choice ของคำถามนั้น</p>
              <p><code>*</code> ถ้าใส่คำที่ไม่ตรงกับ choice ของคำถามนั้น คำตอบจะเป็นค่าว่างและไม่เกิดคำตอบในคำถามนั้นขึ้น</p>
              <h4><u><code>ตัวอย่าง</code></u></h4>
              <div class="row m-t-sm">
                <div class="col-sm-6">
                  <p><code>จากภาพด้านล่าง</code> จะเป็น Choice ทั้งหมดของคำถาม "รายชื่อแปลงปลูก"
                  <p><code>*</code> วิธี download choice <strong><a href="#downloadtemplate">Download Choice</a></strong></p>
                  <div class="panel shift b-light" data-toggle="shift:insertBefore" data-target="#shift-target">
                    <div class="panel-body">
                      <img src="{{asset('theme/importdata/choiceList.png')}}" class="m-r-sm" alt="scale">
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <p><code>จากภาพด้านล่าง</code> จะเป็นการใส่คำตอบใน คำถาม "รายชื่อแปลงปลูก"</p>
                  <p><code>*</code> วิธี download Template <strong><a href="#downloadtemplate">Download Template</a></strong></p>
                  <div class="panel shift b-light"  data-toggle="shift:insertBefore" data-target="#shift-target">
                    <div class="panel-body" >
                      <img src="{{asset('theme/importdata/type3.png')}}"  class="m-r-sm" alt="scale">
                    </div>
                  </div>
                </div>
              </div>

              <h3  id="typeInnerForm" class="text-success">การใส่คำตอบในคำถามประเภท Type innerForm</h3>
              <p><code>*</code> ใส่เลขของแถวที่อยู่ใน Sheet InnerForm ของคำถามนั้น</p>
              <p><code>*</code> กรณีที่ innerForm มีหลายแถว ให้ใส่แถวแรกและใช้ "," คั่นด้วยแถวสุดท้าย (3,10)</p>
              <h4><u><code>ตัวอย่าง</code></u></h4>
              <div class="row m-t-sm">
                <div class="col-sm-6">
                  <p><code>จากภาพด้านล่าง</code> จะเป็นคำถาม ที่เป็น Type InnerForm</p>
                  <div class="panel shift b-light" data-toggle="shift:insertBefore" data-target="#shift-target">
                    <div class="panel-body">
                      <img src="{{asset('theme/importdata/type7.png')}}" class="m-r-sm" alt="scale">
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <p><code>จากภาพด้านล่าง</code> จะเป็น sheet ของ innerForm ข้อมูลพื้นฐานต้นชาน้ำมัน</p>
                  <div class="panel shift b-light"  data-toggle="shift:insertBefore" data-target="#shift-target">
                    <div class="panel-body" style="max-height: 10;overflow-y: scroll;">
                      <img src="{{asset('theme/importdata/innerForm.png')}}" class="m-r-sm" alt="scale">
                    </div>
                  </div>
                </div>
              </div>
              <!--<h3  id="typeLatLong" class="text-success">การใส่คำตอบในคำถามประเภท Type LatLong (<code>ยังไม่รองรับ</code>)</h3>-->
              <h3 id="importData" class="text-success">Import ข้อมูล<small> </small></h3>
              <p>สามารถดาวโหลดไฟล์ Template ได้ที่ <strong><a target="_blank" href="{{ URL::to('/import/data/index') }}">Import Data</a></strong></p>
              <p><code>1.</code> เมื่อเข้าไปที่ <strong><a target="_blank" href="{{ URL::to('/import/data/index') }}">Import Data</a></strong> จะเห็นช่อง <strong>Import Data</strong> กดที่ Choose File และเลือกไฟล์ .xlsx ที่ต้องการและกดปุ่ม Upload  </p>
              <div class="panel shift b-light" data-toggle="shift:insertBefore" data-target="#shift-target">
                <div class="panel-body">
                  <img src="{{asset('theme/importdata/import.png')}}" class="m-r-sm" alt="scale">
                </div>
              </div>
            </div>
          </section>
        </section>
      </section>
    </section>
  </section>
  <script src="{{asset('theme/js/jquery.min.js')}}"></script>
  <script src="{{asset('theme/js/bootstrap.js')}}"></script>
  <script src="{{asset('theme/js/app.js')}}"></script>
  <script src="{{asset('theme/js/js/slimscroll/jquery.slimscroll.min.js')}}"></script>
  <script src="{{asset('theme/js/app.plugin.js')}}"></script>
</body>
</html>