<?php
trait operation {

public function login()
{
    if (isset($_POST['login'])) {
        $user_name = $this->rpv('username');
        $pass = sha1($this->rpv('pass'));
        $sql = "select * from admin where user_name = '$user_name' and pass = '$pass'";
        if ($this->aut($sql)) {
            foreach ($this->getdata($sql) as $key => $v) {
                $_SESSION['user_id'] = $v['id'];
                $_SESSION['name'] = $v['name'];
                $_SESSION['desig'] = $v['desig'];
                $this->redirect(domain.'dashboard');
            }
        }else{
            $_SESSION['lmsg'] = 'Login Failed! Wrong username or password';
        }
        $this->redirect(domain.'login');
    }
}





public function investors()
{
    if (isset($_POST['save'])) {
        $id = $_POST['save'];
        $ar = $this->rpost(['name','number','address','commission','cus_id']);
        if ($id > 0) {
            if ($this->qedit('investor',$ar,'id',$id)) {
                $msg = 'Updated successfully';
            }else{
                $msg = 'Updated fail';
            }
        }else{
            if ($this->adddata('investor',$ar)) {
                $id = $this->lastid;
                $msg = 'Created successfully';
            }else{
                $msg = 'Created fail';
            }
        }
        
        $_SESSION['msg'] = $msg;
        $this->redirect($this->refpg());
    }
    
    
    
    if (isset($_GET['del_mem'])) {
        if ($this->delete('delete from member where id ='.$_GET['del_mem'])) {
            $_SESSION['msg'] = 'Deleted successfull';
        }else{
            $_SESSION['msg'] = 'Deleted fail';
        }
        $this->redirect($this->refpg());
    }

    
}





public function generate_payable()
{
    if (isset($_POST['save'])) {
        $sl = 0;
        if (isset($_POST['member_id'])) {
            $cdate = $this->cdate();
            if (!empty($_POST['member_id'])) {
                $per_share = $this->share_info()['per_share'];
                foreach ($_POST['member_id'] as $key => $v) {
                    foreach ($this->getFull('member','*',' and id ='.$v) as $key => $r) {
                        $amount = $this->rpv('others_amount')>0?$this->rpv('others_amount'):$r['shares'];
                        $month = $this->rpv('bil_month');
                        if ($this->rpv('payable_type') == 'others') {
                            $amount = $this->rpv('others_amount');
                            $month = $this->rpv('remarks');
                        }
                        
                        $amount = $amount * $r['shares'];
                        
                        $ar = [
                            'generate_type'=>$this->rpv('payable_type'),
                            'remarks'=>$this->rpv('remarks'),
                            'month'=>$month,
                            'member_id'=>$r['id'],
                            'amount'=>$amount,
                            'type'=>'generate',
                            'cdate'=>$cdate,
                            'full_date'=>$cdate.' '.$this->cdate('H:i:s'),
                            'created_by'=>$this->uid()
                        ];
                        if ($this->adddata('ledger',$ar)) {
                            $sl++;
                        }
                    }
                }
            }
        }
        if ($sl > 0) {
            $_SESSION['msg'] = 'Payable generated successfull';
        }
        
        $this->redirect($this->refpg());
    }

    if (isset($_GET['del_id'])) {
        if ($this->delete('delete from ledger where type = "generate" and id ='.$_GET['del_id'])) {
            $_SESSION['msg'] = 'Deleted successfull';
        }else{
            $_SESSION['msg'] = 'Deleted fail';
        }
        $this->redirect($this->refpg());
    }
    
}



public function collection()
{
     
    if (isset($_POST['save'])) {
        $i = 0;
        $id = $_POST['save'];
        $col_type = $this->rpv('col_type');
        $cdate = $this->rpv('cdate');
        $full_date = $cdate.' '.$this->cdate('H:i:s');
        $member_id = $this->rpv('member_id');
        $max = $this->getdata('select max(group_id) as m from ledger where type = "collection"')[0]['m'];
        $group_id = $max>0?$max+1:1;
        $amount = $_POST['amount'];

        $month_ar = explode('}', $this->rpv('month'));
        $month = @$month_ar[0];
        $generate_type = @$month_ar[1];
        
        $status = 0;
        $img = $this->image_upload('img',($this->is_mem_login()?'../':'').'images/voucher/');
        
        $ar = [
            'group_id'=>$group_id,
            'amount'=>$amount,
            'remarks'=>$this->rpv('remarks'),
            'method_id'=>$this->rpv('method_id'),
            'month'=>$month,
            'generate_type'=>$generate_type,
            'type'=>'collection',
            'cdate'=>$cdate,
            'full_date'=>$full_date,
            'status'=>$status,
            'img'=>$img,
            'created_by'=>$this->uid(),
        ];

        if ($col_type == 'invest') {
            $ar['investor_id'] = $this->rpv('investor_id');
        }else{
            $ar['member_id'] = $member_id;
        }
        if ($amount > 0) {
            if ($this->adddata('ledger',$ar)) {
                $_SESSION['msg'] = 'Collection saved successfull';
            }
        }

        $this->redirect($this->refpg());
            
    }

    if (isset($_GET['del_id'])) {
        if ($this->delete('delete from ledger where id ='.$_GET['del_id'])) {
            $_SESSION['msg'] = 'Deleted successfull';
        }else{
            $_SESSION['msg'] = 'Deleted fail';
        }
        $this->redirect($this->refpg());
    }
    if (isset($_GET['app_id'])) {
        if ($this->edit('update ledger set status = 1,approved_by='.$this->uid().',approved_date="'.$this->cdate('Y-m-d H:i:s').'" where id ='.$_GET['app_id'])) {
            $ar = $this->getAll('ledger',' and id ='.$_GET['app_id']);
            $sms = $this->getonecol('des','sms_tem','title','Bill Collection');
            $sms = str_replace(['{col_amount}','{month}'],[$ar['amount'],$ar['month']],$sms);
            
            
            $_SESSION['msg'] = 'Approved successfull';
        }else{
            $_SESSION['msg'] = 'Approved fail';
        }
        $this->redirect($this->refpg());
    }
    
}

public function investment()
{
    if (isset($_POST['save'])) {
        $i = 0;
        $id = $_POST['save'];
        $date = $this->cdate('Y-m-d H:i:s');
        $ar = [
            'investor_id'=>$this->rpv('investor_id'),
            'title'=>$this->rpv('title'),
            'des'=>$this->rpv('des'),
            'invest_amount'=>$this->rpv('invest_amount'),
            'collection'=>$this->rpv('collection'),
            'payable_amount'=>round($this->rpv('invest_amount')-$this->rpv('collection'),2),
            'profit_rate'=>$this->rpv('profit_rate'),
            'total_return_amount'=>$this->rpv('total_return_amount'),
            'total_installment'=>$this->rpv('total_installment'),
            'start_installment_date'=>$this->rpv('start_installment_date'),
            'installment_amount'=>$this->rpv('installment_amount'),
            'installment_period'=>$this->rpv('installment_period'),
            'invest_type'=>$this->rpv('invest_type'),
            'cdate'=>$date,
            'created_by'=>$this->uid(),
        ];
        if ($id > 0) {
            $submit = $this->qedit('investment',$ar,'id',$id);
        }else{
            $submit = $this->adddata('investment',$ar);
        }
        if ($submit) {
            $_SESSION['msg'] = 'Saved successfull';
        }else{
            $_SESSION['msg'] = 'Saved fail';
        }
        

        $this->redirect($this->refpg());
            
    }

    if (isset($_GET['del_id'])) {
        if ($this->delete('delete from investment where id ='.$_GET['del_id'])) {
            $_SESSION['msg'] = 'Deleted successfull';
        }else{
            $_SESSION['msg'] = 'Deleted fail';
        }
        $this->redirect($this->refpg());
    }
    
}


public function payment()
{
    if (isset($_POST['save'])) {
        $i = 0;
        $id = $_POST['save'];
        $cdate = $this->rpv('cdate');
        $full_date = $cdate.' '.$this->cdate('H:i:s');
        $expense_ledger_id = $this->rpv('expense_ledger_id');
        $max = $this->getdata('select max(group_id) as m from ledger where type = "payment"')[0]['m'];
        $group_id = $max>0?$max+1:1;
        $amount = $_POST['amount'];
        $ar = [
            'group_id'=>$group_id,
            'expense_ledger_id'=>$expense_ledger_id,
            'amount'=>$amount,
            'remarks'=>$this->rpv('remarks'),
            'method_id'=>$this->rpv('method_id'),
            'type'=>'payment',
            'cdate'=>$cdate,
            'full_date'=>$full_date,
            'created_by'=>$this->uid(),
        ];
        if ($amount > 0) {
            if ($this->adddata('ledger',$ar)) {
                $_SESSION['msg'] = 'Payment saved successfull';
            }
        }

        $this->redirect($this->refpg());
            
    }
    if (isset($_GET['del_id'])) {
        if ($this->aut('select * from ledger where id ='.$_GET['del_id'].' and cdate in("'.date('Y-m-d').'","'.date('Y-m-d',strtotime('-1 days')).'")')) {
            if ($this->delete('delete from ledger where id ='.$_GET['del_id'])) {
                $_SESSION['msg'] = 'Deleted successfull';
            }else{
                $_SESSION['msg'] = 'Deleted fail';
            }
        }
        $this->redirect($this->refpg());
    }
    
}




public function expense_ledger()
{
    if (isset($_POST['save'])) {
        $id = $_POST['save'];
        $ar = $this->rpost(['name','type']);
        
        if ($id > 0) {
            if ($this->qedit('expense_ledger',$ar,'id',$id)) {
                $msg = 'Updated successfully';
            }else{
                $msg = 'Updated fail';
            }
        }else{
            if ($this->adddata('expense_ledger',$ar)) {
                $msg = 'Created successfully';
            }else{
                $msg = 'Created fail';
            }
        }
        $_SESSION['msg'] = $msg;
        $this->redirect($this->refpg());
    }
    
}


public function sms_tem()
{
    if (isset($_POST['save'])) {
        $id = $_POST['save'];
        $ar = $this->rpost(['title','des']);
        
        if ($id > 0) {
            if ($this->qedit('sms_tem',$ar,'id',$id)) {
                $msg = 'Updated successfully';
            }else{
                $msg = 'Updated fail';
            }
        }else{
            if ($this->adddata('sms_tem',$ar)) {
                $msg = 'Created successfully';
            }else{
                $msg = 'Created fail';
            }
        }
        $_SESSION['msg'] = $msg;
        $this->redirect($this->refpg());
    }

    if (isset($_GET['del_id'])) {
        if ($this->delete('delete from sms_tem where id ='.$_GET['del_id'])) {
            $_SESSION['msg'] = 'Deleted successfull';
        }else{
            $_SESSION['msg'] = 'Deleted fail';
        }
        $this->redirect('sms_tem');
    }
    
}

public function get_user()
{
    if (isset($_POST['save'])) {
        $id = $_POST['save'];
        $ar = $this->rpost(['name','number','email','user_name']);
        $pass = $this->rpv('pass');
        if ($pass != '') {
            $ar['pass'] = sha1($pass);
        }
        $img = $this->image_upload('img','images/other/');
        $ar['img'] = $img;

        $access = implode(',',$_POST['access']);
        $ar['access'] = $access;
        
        
        if ($id > 0) {
            if ($this->qedit('admin',$ar,'id',$id)) {
                $msg = 'Updated successfully';
            }else{
                $msg = 'Updated fail';
            }
        }else{
            $ar['date'] = date('Y-m-d');
            if ($this->adddata('admin',$ar)) {
                $msg = 'Created successfully';
            }else{
                $msg = 'Created fail';
            }
        }
        $_SESSION['msg'] = $msg;
        $this->redirect($this->refpg());
    }

    if (isset($_GET['del_id'])) {
        if ($this->delete('delete from admin where id ='.$_GET['del_id'])) {
            $_SESSION['msg'] = 'Deleted successfull';
        }else{
            $_SESSION['msg'] = 'Deleted fail';
        }
        $this->redirect('user');
    }
    
}

 

public function get_pages()
{
    if (isset($_POST['save'])) {
        $id = $_POST['save'];
        $ar = $this->rpost(['name','parent_id','url','page_title','icon','sl']);
        $img = $this->image_upload('img','images/req/',500000,$_POST['url'].'.jpg');
        $ar['img'] = $img;
        if (!empty(@$_POST['option'])) {
            $option = implode(',',@$_POST['option']);
        }
        
        $ar['option'] = @$option;

        if ($id > 0) {
            if ($this->qedit('pages',$ar,'id',$id)) {
                $msg = 'Updated successfully';
            }else{
                $msg = 'Updated fail';
            }
        }else{
            if ($this->adddata('pages',$ar)) {
                $id = $this->lastid;
                $msg = 'Created successfully';
            }else{
                $msg = 'Created fail';
            }
        }

        $_SESSION['msg'] = $msg;
        $this->redirect($this->refpg());
    }

    if (isset($_GET['del_id'])) {
        if ($this->delete('delete from pages where id ='.$_GET['del_id'])) {
            $_SESSION['msg'] = 'Deleted successfull';
        }else{
            $_SESSION['msg'] = 'Deleted fail';
        }
        $this->redirect('mng_pages');
    }
}


public function save_method()
{
    if (isset($_POST['save'])) {
        $id = $_POST['save'];
        $ar = $this->rpost(['name','parent_id']);
        if ($id > 0) {
            if ($this->qedit('method',$ar,'id',$id)) {
                $msg = 'Updated successfully';
            }else{
                $msg = 'Updated fail';
            }
        }else{
            if ($this->adddata('method',$ar)) {
                $msg = 'Created successfully';
            }else{
                $msg = 'Created fail';
            }
        }
        $_SESSION['msg'] = $msg;
        $this->redirect($this->refpg());
    }

}

public function save_setting()
{
    if (isset($_POST['save'])) {
        $ar = $this->rpost(['company_name','address','monthly_fee','yearly_fee']);
        $this->image_upload('logo','images/logo/',500000,'logo.png');
        if ($this->qedit('settings',$ar,'id',1)) {
            $msg = 'Updated successfully';
        }else{
            $msg = 'Updated fail';
        }

        $_SESSION['msg'] = $msg;
        $this->redirect($this->refpg());
    }

}
public function balance_transfer()
{
    if (isset($_POST['save'])) {
        $amount = $_POST['amount'];
        $from_method_id = $_POST['from_method_id'];
        $to_method_id = $_POST['to_method_id'];
        
        
        $ar = $this->rpost(['name','parent_id']);
        $max = $this->getdata('select max(group_id) as m from ledger where type = "transfer"')[0]['m'];
        $group_id = $max>0?$max+1:1;
        
        $cdate = $this->cdate();
        $full_date = $cdate.' '.$this->cdate('H:i:s');
        $ar = [
            'group_id'=>$group_id,
            'amount'=>$amount,
            'cdate'=>$cdate,
            'full_date'=>$full_date,
            'created_by'=>$this->uid(),
        ];
        
        $balance = $this->get_method_balance($from_method_id)['b'];
        
        if($balance > 0){
            $this->adddata('ledger',array_merge($ar,['method_id'=>$to_method_id,'type'=>'transfer_in']));
            $this->adddata('ledger',array_merge($ar,['method_id'=>$from_method_id,'type'=>'transfer_out']));
            $_SESSION['msg'] = 'Saved Successfull';
        }else{
            $_SESSION['msg'] = 'Failed! Insufficient Balance';
        }

        $this->redirect($this->refpg());

    }
    
    if (isset($_GET['del_id'])) {
        if ($this->delete('delete from ledger where type in("transfer_in","transfer_out") and group_id ='.$_GET['del_id'])) {
            $_SESSION['msg'] = 'Deleted successfull';
        }else{
            $_SESSION['msg'] = 'Deleted fail';
        }
        $this->redirect($this->refpg());
    }

}



}
