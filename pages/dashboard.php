<style>
:root{
  --primary:#4f46e5;
  --success:#22c55e;
  --danger:#ef4444;
  --warning:#f59e0b;
  --bg:#f1f5f9;
  --card:rgba(255,255,255,.85);
  --text:#0f172a;
  --muted:#64748b;
  --radius:16px;
}

.dashboard .table td,
.dashboard .table th{
  padding:.6rem .65rem !important;
  vertical-align:middle;
  font-size:12px;
}

.bg-comman{
  background:var(--card);
  backdrop-filter: blur(12px);
  border-radius:var(--radius);
  box-shadow:0 10px 30px rgba(15,23,42,.08);
}

.card{
  border:0;
  transition:.35s cubic-bezier(.4,0,.2,1);
}
.card:hover{
  transform:translateY(-6px) scale(1.01);
  box-shadow:0 20px 45px rgba(15,23,42,.15);
}

.db-info h6{
  font-size:12px;
  text-transform:uppercase;
  letter-spacing:.08em;
  color:var(--muted);
  margin-bottom:6px;
  font-weight:600;
}

.db-info h3{
  font-size:20px;
  font-weight:800;
  color:var(--text);
  margin:0;
}

.db-icon{
  width:52px;
  height:52px;
  display:flex;
  align-items:center;
  justify-content:center;
  border-radius:14px;
  font-size:22px;
  color:#fff;
}

/* Gradient Stat Cards */
.stat-share .db-icon{
  background:linear-gradient(135deg,#f97316,#fb923c);
}
.stat-paid .db-icon{
  background:linear-gradient(135deg,#22c55e,#4ade80);
}
.stat-advance .db-icon{
  background:linear-gradient(135deg,#4f46e5,#818cf8);
}
.stat-expense .db-icon{
  background:linear-gradient(135deg,#ef4444,#f87171);
}
.stat-cash .db-icon{
  background:linear-gradient(135deg,#eab308,#fde047);
}

/* Section Header */
.card-header{
  background:transparent !important;
  border-bottom:1px solid #e5e7eb;
}
.pg_title{
  font-size:16px;
  font-weight:800;
  color:var(--text);
  letter-spacing:.03em;
}

/* Table */
.table thead th{
  font-size:11px;
  letter-spacing:.1em;
  text-transform:uppercase;
  color:var(--muted);
  border-bottom:1px solid #e5e7eb;
}

.table tbody tr{
  transition:.2s;
}
.table tbody tr:hover{
  background:#f8fafc;
}

.table tfoot th{
  background:#eef2ff;
  font-weight:800;
  color:#1e1b4b;
}

/* Month pill */
.month-pill{
  display:inline-block;
  padding:2px 8px;
  border-radius:999px;
  background:#e0e7ff;
  color:#3730a3;
  font-size:12px;
}

/* Responsive */
@media(max-width:768px){
  .db-info h3{font-size:22px;}
  .db-icon{width:46px;height:46px;}
}
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
<div class="row g-4">

  <div class="col-md-3 col-sm-6 col-12 d-flex stat-share">
    <div class="card bg-comman w-100">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div class="db-info">
          <h6>Number of Member</h6>
          <h3><?php echo $db->nf($tmem,0);?></h3>
        </div>
        <div class="db-icon"><i class="fa fa-coins"></i></div>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-12 d-flex stat-share">
    <div class="card bg-comman w-100">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div class="db-info">
          <h6>Number of Share</h6>
          <h3><?php echo $db->nf($shares,0);?></h3>
        </div>
        <div class="db-icon"><i class="fa fa-coins"></i></div>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-12 d-flex stat-paid">
    <div class="card bg-comman w-100">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div class="db-info">
          <h6>Paid This Month</h6>
          <h3><?php echo $db->nf(@$paid,0);?></h3>
        </div>
        <div class="db-icon"><i class="fa fa-money-bill"></i></div>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-12 d-flex stat-advance">
    <div class="card bg-comman w-100">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div class="db-info">
          <h6>Advance</h6>
          <h3><?php echo $db->nf(@$advance,0);?></h3>
        </div>
        <div class="db-icon"><i class="fa fa-calendar-check"></i></div>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-12 d-flex stat-expense">
    <div class="card bg-comman w-100">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div class="db-info">
          <h6>Total Expense</h6>
          <h3><?php echo $db->nf(@$cash_ar['payment'],0);?></h3>
        </div>
        <div class="db-icon"><i class="fa fa-file-invoice-dollar"></i></div>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-12 d-flex stat-cash">
    <div class="card bg-comman w-100">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div class="db-info">
          <h6>Cash Balance</h6>
          <h3><?php echo $db->nf(@$cash,0);?></h3>
        </div>
        <div class="db-icon"><i class="fa fa-money-bill-wave"></i></div>
      </div>
    </div>
  </div>
  <?php
  $fund = $db->get_method_balance(9);
  $total_b = $db->get_method_balance();
  ?>
  <div class="col-md-3 col-sm-6 col-12 d-flex stat-cash">
    <div class="card bg-comman w-100">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div class="db-info">
          <h6>Fixed Diposite</h6>
          <h3><?php echo $db->nf(@$fund['b'],0);?></h3>
        </div>
        <div class="db-icon" style="background:linear-gradient(135deg, #38166e, #4ade80)"><i class="fa fa-money-bill-wave"></i></div>
      </div>
    </div>
  </div>
  
  <div class="col-md-3 col-sm-6 col-12 d-flex stat-cash">
    <div class="card bg-comman w-100">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div class="db-info">
          <h6>Total Balance</h6>
          <h3><?php echo $db->nf(@$total_b['b'],0);?></h3>
        </div>
        <div class="db-icon"><i class="fa fa-money-bill-wave"></i></div>
      </div>
    </div>
  </div>



  <div class="col-xl-7 col-sm-7 col-12">
    <div class="card border-0 bg-comman w-100">
      <div class="card-header no-print" style="padding:0.3rem 1rem;background: #fff;">
        <div class="pg_title text-center" style="float: none;">Due List</div>
      </div>
      <div class="card-body">
        <div class="table-responsive dashboard">
          <table class="table ">
            <thead>
              <tr>
                <th style="width: 270px;">Company Name</th>
                <th style="width: 270px;">Member Name</th>
                <th style="width: 270px;">Number of Share</th>
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
                      $mlist .= '<span style="white-space:nowrap">'.date('M y',strtotime($value['b'].'-01')).'</span>, ';
                    }else{
                      $mlist .= ucwords($value['b']).', ';
                    }
                    
                  }
                  $mlist = trim($mlist,', ');
                  
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
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    <div class="card border-0 bg-comman w-100">
      <div class="card-header no-print" style="padding:0.3rem 1rem;background: #fff;">
        <div class="pg_title text-center" style="float: none;">Advance Paid Member List</div>
      </div>
      <div class="card-body">
        <div class="table-responsive dashboard">
          <table class="table ">
            <thead>
              <tr>
                <th style="width: 270px;">Member Name</th>
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
                    $advance_month[] = !empty($a['month'])?'<span style="white-space:nowrap">'.date('M y',strtotime($a['month'].'-01')).'</span>':'';  
                    $advance_amount += $a['amount'];
                  }
                  $advance_month = implode(',',$advance_month);
                    
                 if( !empty($advance_month)){
                     
                 
                  echo ' <tr>
                    <td class="text-left">'.($sl++).'. '.$v['name'].' - '.$v['shares'].'</td>
                    <td class="text-left">'.str_replace(',',', ',$advance_month).'</td>
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
      <div class="form-group" style="width: 100%;">
        <div class="card border-0 bg-comman w-100">
          <div class="card-header no-print" style="padding:0.3rem 1rem;background: #fff;">
            <div class="pg_title text-center" style="float: none;">Month Wise Due</div>
          </div>
          <div class="card-body">
            <div class="table-responsive dashboard">
              <table class="table ">
                <thead>
                  <tr>
                    <th>SL</th>
                    <th>Month</th>
                    <th>Total Amount</th>
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
      </div>


      <div class="form-group" style="width: 100%;">
        <div class="card border-0 bg-comman w-100">
          <div class="card-header no-print" style="padding:0.3rem 1rem;background: #fff;">
            <div class="pg_title text-center" style="float: none;">Recently Expenses</div>
          </div>
          <div class="card-body">
            <div class="table-responsive dashboard">
              <table class="table ">
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
                  order by a.id desc limit 0,20
                  ';
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
</div>


        
    