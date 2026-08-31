<style>
.dashboard .table td, .dashboard .table th { padding: .6rem .65rem !important; vertical-align: middle; font-size: 12px; }
.month-pill { display: inline-block; padding: 2px 8px; border-radius: 999px; background: #e0e7ff; color: #3730a3; font-size: 12px; }
</style>
<?php
$mem_ar = $db->getdata('select sum(shares) as c,count(id) as t from member where status = 1')[0];
$tmem = $mem_ar['t'];
$shares = $mem_ar['c'];
$cash_ar = $db->getdata('
select sum(if(type="collection",amount,0)) as collection,
sum(if(type="payment",amount,0)) as payment, 
sum(if(type="transfer_in",amount,0)) as ins, 
sum(if(type="transfer_out",amount,0)) as outs 
from ledger where method_id = 1')[0];

$cash = $cash_ar['collection'] - $cash_ar['payment'] - $cash_ar['outs'] + $cash_ar['ins'];
$monthly_payable = $db->getdata('select sum(amount) as b from ledger where type = "generate" and cdate between "' . $db->cdate('Y-m-01') . '" and "' . $db->cdate('Y-m-d') . '"')[0]['b'];

$paid = $db->getdata('select sum(amount) as b from ledger where type = "collection" and member_id > 0 and cdate between "' . $db->cdate('Y-m-01') . '" and "' . $db->cdate('Y-m-d') . '"')[0]['b'];
$advance = $db->getdata('select sum(amount) as b from ledger where type = "collection" and member_id > 0 and date(concat(month,"-01")) > "'.date('Y-m-01').'"')[0]['b'];

?>
<div class="row g-4 mb-4">

  <div class="col-md-3 col-sm-6 col-12">
    <div class="stat-card">
      <div class="stat-icon orange"><i class="fa fa-users"></i></div>
      <div class="stat-info">
        <h6>Total Members</h6>
        <h3><?php echo $db->nf($tmem,0);?></h3>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-12">
    <div class="stat-card">
      <div class="stat-icon blue"><i class="fa fa-coins"></i></div>
      <div class="stat-info">
        <h6>Total Shares</h6>
        <h3><?php echo $db->nf($shares,0);?></h3>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-12">
    <div class="stat-card">
      <div class="stat-icon green"><i class="fa fa-money-bill"></i></div>
      <div class="stat-info">
        <h6>Paid This Month</h6>
        <h3><?php echo $db->nf(@$paid,0);?></h3>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-12">
    <div class="stat-card">
      <div class="stat-icon purple"><i class="fa fa-calendar-check"></i></div>
      <div class="stat-info">
        <h6>Advance</h6>
        <h3><?php echo $db->nf(@$advance,0);?></h3>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-12">
    <div class="stat-card">
      <div class="stat-icon red"><i class="fa fa-file-invoice-dollar"></i></div>
      <div class="stat-info">
        <h6>Total Expense</h6>
        <h3><?php echo $db->nf(@$cash_ar['payment'],0);?></h3>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-12">
    <div class="stat-card">
      <div class="stat-icon yellow"><i class="fa fa-money-bill-wave"></i></div>
      <div class="stat-info">
        <h6>Cash Balance</h6>
        <h3><?php echo $db->nf(@$cash,0);?></h3>
      </div>
    </div>
  </div>

  <?php
  $fund = $db->get_method_balance(9);
  $total_b = $db->get_method_balance();
  ?>

  <div class="col-md-3 col-sm-6 col-12">
    <div class="stat-card">
      <div class="stat-icon teal"><i class="fa fa-piggy-bank"></i></div>
      <div class="stat-info">
        <h6>Fixed Deposit</h6>
        <h3><?php echo $db->nf(@$fund['b'],0);?></h3>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-12">
    <div class="stat-card">
      <div class="stat-icon indigo"><i class="fa fa-chart-pie"></i></div>
      <div class="stat-info">
        <h6>Total Balance</h6>
        <h3><?php echo $db->nf(@$total_b['b'],0);?></h3>
      </div>
    </div>
  </div>

</div>

<div class="row g-4">

  <div class="col-xl-7 col-sm-7 col-12">
    <div class="card">
      <div class="card-header no-print">
        <div class="pg_title">Due List</div>
      </div>
      <div class="card-body">
        <div class="table-responsive dashboard">
          <table class="table">
            <thead>
              <tr>
                <th style="width: 270px;">Company Name</th>
                <th style="width: 270px;">Member Name</th>
                <th style="width: 270px;">Shares</th>
                <th>Month</th>
                <th>Due</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = 'select b.company_name,b.shares,b.name,b.number,sum(if(a.type = "generate",amount,-amount)) as b,a.member_id from ledger a  
              inner join member b on b.id = a.member_id
              group by a.member_id order by b desc';
                $ar = $db->getdata($sql);
                $total = $tad = 0;
                foreach ($ar as $key => $v) {
                  $mlist = '';
                  $sql = "select if(sum(if(type = 'generate',amount,-amount))>0,month,null) as b,generate_type from ledger where member_id =".$v['member_id']." group by month having b is not null order by id asc";
                  foreach ($db->getdata($sql) as $value) {
                    if ($value['generate_type'] == 'monthly') {
                      $mlist .= '<span class="month-pill">'.date('M y',strtotime($value['b'].'-01')).'</span> ';
                    } else {
                      $mlist .= '<span class="month-pill">'.ucwords($value['b']).'</span> ';
                    }
                  }
                  $mlist = trim($mlist);
                 if($v['b'] > 0){
                  echo ' <tr>
                    <td class="text-left">'.($key+1).'. '.$v['company_name'].'</td>
                    <td class="text-left">'.$v['name'].'</td>
                    <td class="text-center">'.$v['shares'].'</td>
                    <td class="text-center">'.$mlist.'</td>
                    <td class="text-right">'.$db->nf($v['b'],0).'</td>
                  </tr>';
                  $total += $v['b'];
                    }
                }
                ?>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="4">Total</th>
                <th class="text-right"><?php echo $db->nf($total);?></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header no-print">
        <div class="pg_title">Advance Paid Members</div>
      </div>
      <div class="card-body">
        <div class="table-responsive dashboard">
          <table class="table">
            <thead>
              <tr>
                <th>Member</th>
                <th>Month</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sl = 1;
              $sql = 'select b.shares,b.name,b.number,sum(if(a.type = "generate",amount,-amount)) as b,a.member_id from ledger a  
              inner join member b on b.id = a.member_id
              group by a.member_id order by b desc';
                $ar = $db->getdata($sql);
                $total = $tad = 0;
                foreach ($ar as $key => $v) {
                  $mlist = trim($mlist,', ');
                  $advance_month = [];$advance_amount = 0;
                  foreach($db->getdata('select month,amount from ledger where type = "collection" and member_id = '.$v['member_id'].' and date(concat(month,"-01")) > "'.date('Y-m-01').'"') as $a){
                    $advance_month[] = !empty($a['month'])?'<span class="month-pill">'.date('M y',strtotime($a['month'].'-01')).'</span>':'';  
                    $advance_amount += $a['amount'];
                  }
                  $advance_month = implode(' ',$advance_month);
                 if( !empty($advance_month)){
                  echo ' <tr>
                    <td class="text-left">'.($sl++).'. '.$v['name'].' - '.$v['shares'].'</td>
                    <td class="text-left">'.$advance_month.'</td>
                    <td class="text-right">'.$db->nf($advance_amount).'</td>
                  </tr>';
                  $tad += $advance_amount;
                    }
                }
                ?>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="2">Total</th>
                <th class="text-right"><?php echo $db->nf($tad);?></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-5 col-sm-5 col-12 d-flex">
    <div style="width: 100%;">
      <div class="card">
        <div class="card-header no-print">
          <div class="pg_title">Month Wise Due</div>
        </div>
        <div class="card-body">
          <div class="table-responsive dashboard">
            <table class="table">
              <thead>
                <tr>
                  <th>SL</th>
                  <th>Month</th>
                  <th>Total</th>
                  <th>Paid</th>
                  <th>Due</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = 'select month,generate_type,sum(if(type = "generate",amount,0)) as gen,sum(if(type = "collection",amount,0)) as paid from ledger group by month having gen-paid>0 order by month asc';
                $ar = $db->getdata($sql);
                $tgen = $tpaid = $tdue = 0;
                foreach ($ar as $key => $v) {
                  $tgen += $v['gen'];
                  $tpaid += $v['paid'];
                  $tdue += $v['gen']-$v['paid'];
                  $month = $v['month'];
                  if ($v['generate_type'] == 'monthly') {
                    $month = date('M Y',strtotime($v['month'].'-01'));
                  }
                  $month = ucwords($month);
                  echo ' <tr>
                    <td>'.($key+1).'</td>                
                    <td class="text-left">'.$month.'</td>
                    <td class="text-right">'.$db->nf($v['gen'],0).'</td>
                    <td class="text-right">'.$db->nf($v['paid'],0).'</td>
                    <td class="text-right">'.$db->nf($v['gen']-$v['paid'],0).'</td>
                  </tr>';
                  }
                  ?>
                  <tr>
                    <th colspan="2">Total</th>
                    <th class="text-right"><?php echo $db->nf($tgen);?></th>
                    <th class="text-right"><?php echo $db->nf($tpaid);?></th>
                    <th class="text-right"><?php echo $db->nf($tdue);?></th>
                  </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header no-print">
          <div class="pg_title">Recent Expenses</div>
        </div>
        <div class="card-body">
          <div class="table-responsive dashboard">
            <table class="table">
              <thead>
                <tr>
                  <th>SL</th>
                  <th>Date</th>
                  <th>Ledger</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = 'select b.name,a.amount,a.cdate from ledger a  
                inner join expense_ledger b on b.id = a.expense_ledger_id
                where a.type = "payment"
                order by a.id desc limit 0,20';
                  $ar = $db->getdata($sql);
                  foreach ($ar as $key => $v) {
                    echo ' <tr>
                      <td>'.($key+1).'</td>                
                      <td class="text-center">'.$db->setdate($v['cdate']).'</td>
                      <td class="text-center">'.$v['name'].'</td>
                      <td class="text-right">'.$db->nf($v['amount']).'</td>
                    </tr>';
                  }
                  ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
