</div>

</div>
<!-- <footer>
  <p>Copyright © 2023 E-School.</p>
</footer> -->

<div class="modalbtn">
  
  <!-- Modal     data-bs-backdrop="static"
    data-bs-keyboard="false" -->
  <div
    class="modal fade shadow border-0"
    id="modal_id"
    tabindex="-1"

    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content" id="modal-content">
        
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function print_page(areaID,css,times){
    var prtContent = document.getElementById(areaID);
    var WinPrint = window.open('', '', 'left=0,top=0,width=1000,height=650,toolbar=0,scrollbars=0,status=0');
    WinPrint.document.write('<html><head>');
    WinPrint.document.write('<link rel="stylesheet" href="<?php echo domain;?>assets/css/print.css">');

    if (css) {
    css = '<style>tr,td{position:unset !important}.no-print{display:none !important;}'+css+'[scope="row"]::before {counter-increment: my-sec-counter;content: counter(my-sec-counter);}body {background-color: #ecf1f5;counter-reset: my-sec-counter;}</style>';
    }else{css = '';}
  
    content = prtContent.innerHTML;
    if (times == 2) {
      content = content+content;
    }else if (times == 3) {
      content = content+content+content;
    }
    WinPrint.document.write('</head>'+css+'<body onload="print();setTimeout(function(){close();},500)">');
    WinPrint.document.write(content);
    WinPrint.document.write('</body></html>');
    WinPrint.document.close();
    WinPrint.focus();
  }


  function view_ipay(id) {
    $('#modal_id').modal('toggle')
    ajax_post('<?php echo domain;?>control.php?view_ipay='+id,'','#modal-content')
  }
  function view_payment_voucher(id) {
    $('#modal_id').modal('toggle')
    ajax_post('<?php echo domain;?>control.php?view_payment_voucher='+id,'','#modal-content')
  }
  function nf(v) {
    let number = v;
    let formattedNumber = number.toLocaleString('en-US', { style: 'decimal', maximumFractionDigits: 2 });
    return (formattedNumber);
  }
  function toast(msg,type='red') {
    $.alert({
        content:msg,
        type: type,
        title: false,
        typeAnimated: true,
        buttons: {
            tryAgain: {
                text: 'Close',
                btnClass: 'btn-'+type,
                action: function(){
                }
            },

        }
    });
  }
  <?php
    if (isset($_SESSION['msg'])) {
      if ($_SESSION['msg'] != '') {
        $type = 'green';
        if (strpos(strtolower($_SESSION['msg']), 'fail')!==false or strpos(strtolower($_SESSION['msg']), 'exit')!==false) {
          $type = 'red';
        }
        echo 'setTimeout(function(){
          toast(\''.strip_tags($_SESSION['msg']).'\',\''.$type.'\')
        },300);';
        unset($_SESSION['msg']);
      }
    }

 
?>
$(document).click(function(event) {
  var target = $(event.target);
  if (!target.closest('.jconfirm-box').length && !target.is('#open-dialog')) {
    $('.jconfirm').remove(); // Remove the confirm dialog
  }
});

function ajax_post(url, json, selectors) {
    $.post(url, json, function (data, status) {
        $(selectors).html(data);
    });
  }
  function showsmsb(e) {
    $('.Show_sms_balance').html(`<img style="width:20px;" src="images/loading.gif">`);
    ajax_post('<?php echo domain;?>control.php?show_sms_balance=1',{},'.Show_sms_balance')
  }
  $('.select2').select2()
</script>
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/plugins/datatables/datatables.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/datatables.js"></script>
  </body>
</html>
