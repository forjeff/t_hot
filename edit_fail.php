<!doctype html>
<html lang="en-US">
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
  <title>Success Notification </title>
  <style>
  /** resets **/
 
  img { border: 0; max-width: 100%; }
  /** typography **/
  h1 {
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    font-size: 2.5em;
    line-height: 1.5em;
    letter-spacing: -0.05em;
    margin-bottom: 20px;
    padding: .1em 0;
    color: #444;
      position: relative;
    overflow: hidden;
    white-space: nowrap;
    text-align: center;
  }
  h1:before,
  h1:after {
    content: "";
    position: relative;
    display: inline-block;
    width: 50%;
    height: 1px;
    vertical-align: middle;
    background: #f0f0f0;
  }
  h1:before {    
    left: -.5em;
    margin: 0 0 0 -50%;
  }
  h1:after {    
    left: .5em;
    margin: 0 -50% 0 0;
  }
  h1 > span {
    display: inline-block;
    vertical-align: middle;
    white-space: normal;
  }
  
  p {
    display: block;
    font-size: 1.35em;
    line-height: 1.5em;
    margin-bottom: 22px;
  }
  
  
  /** page structure **/
  
  #content {
    display: block;
    width: 100%;
    background: #fff;
    padding: 25px 20px;
    padding-bottom: 35px;
    -webkit-box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
    -moz-box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
  }
  
  /** notifications **/
  .notify {
    display: block;
    background: #fff;
    padding: 12px 18px;
    max-width: 400px;
    margin: 0 auto;
    cursor: pointer;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    margin-bottom: 20px;
    box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 2px 0px;
  }
  
  .notify h1 { margin-bottom: 6px; }
  
  .successbox h1 { color: #678361; }
  .errorbox h1 { color: #6f423b; }
  
  .successbox h1:before, .successbox h1:after { background: #cad8a9; }
  .errorbox h1:before, .errorbox h1:after { background: #d6b8b7; }
  
  .notify .alerticon { 
    display: block;
    text-align: center;
    margin-bottom: 15px;
  }
  .go{
    font-size: 15px;
    text-align: center;  
    margin:0px auto;
    position:relative;
  }
  </style>
</head>

<body>
 <?php
    require_once("Member_menu.php");
 ?> 
  <div id="w">
    <div id="content">
      <!-- Icons source http://dribbble.com/shots/913555-Flat-Web-Elements -->
      <div class="notify errorbox">
            <h1>Warning!</h1>
            <span class="alerticon"><img src="error.png" alt="error" /></span>
            <p>修改帳號失敗，請檢查資料格式是否正確</p>
          </div>
      <div class="notify successbox ">
        <button class="go" onclick="gologin()">修改帳號</button>
      </div>
    </div><!-- @end #content -->
  </div><!-- @end #w -->
  <script language="javascript">
      function gologin(){
        window.location.href = "Member_edit.php";
      }
  </script>
</body>
</html>