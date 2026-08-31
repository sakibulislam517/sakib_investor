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
        $ar = $this->rpost(['name','number','address','pass','cus_id']);
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

public function investment()
{
    if (isset($_POST['save_invest'])) {
        $id = (int) $this->rpv('id');
        $investor_id = (int) $this->rpv('investor_id');
        $amount = (float) $this->rpv('amount');
        $remarks = $this->rpv('remarks');
        $type = $this->rpv('type');
        $date = $this->rpv('date') ?: $this->cdate('Y-m-d');

        if ($investor_id > 0 && $amount > 0 && in_array($type, ['invest', 'invest_withdraw'])) {
            $row = [];
            if ($id > 0) {
                $row = $this->getAll('ledger', ' and id = '.$id);
            }

            $group_id = !empty($row['group_id']) ? $row['group_id'] : 'INV-' . date('YmdHis') . '-' . rand(100, 999);

            $ledger = [
                'group_id' => $group_id,
                'investor_id' => $investor_id,
                'remarks' => $remarks,
                'type' => $type,
                'status' => 1,
                'date' => $date,
            ];

            if ($type == 'invest') {
                $ledger['debit'] = $amount;
                $ledger['credit'] = 0;
            } else {
                $ledger['debit'] = 0;
                $ledger['credit'] = $amount;
            }

            if ($id > 0) {
                $ok = $this->qedit('ledger', $ledger, 'id', $id);
                $msg = 'Investment updated successfully';
            } else {
                $ok = $this->adddata('ledger', $ledger);
                $msg = 'Investment added successfully';
            }

            $_SESSION['msg'] = $ok ? $msg : 'Investment save failed';
        } else {
            $_SESSION['msg'] = 'Please select investor, choose type, enter a valid amount and date';
        }

        $this->redirect($this->refpg());
    }

    if (isset($_GET['del_id'])) {
        if ($this->delete('delete from ledger where id ='.(int)$_GET['del_id'].' and type in ("invest","invest_withdraw")')) {
            $_SESSION['msg'] = 'Investment deleted successfully';
        } else {
            $_SESSION['msg'] = 'Investment delete failed';
        }
        $this->redirect($this->refpg());
    }
}

public function profit_generate()
{
    if (isset($_POST['save_profit'])) {
        $profit_amount = (float) $this->rpv('amount');
        $remarks = $this->rpv('remarks');
        $date = $this->rpv('date') ?: $this->cdate('Y-m-d');
        $type = $this->rpv('type');

        if ($type == 'profit_withdraw') {
            $investor_id = (int) $this->rpv('investor_id');
            $amount = (float) $this->rpv('amount');

            if ($investor_id > 0 && $amount > 0) {
                $ledger = [
                    'group_id' => 'PROFIT-WITHDRAW-' . date('YmdHis') . '-' . rand(100, 999),
                    'investor_id' => $investor_id,
                    'debit' => 0,
                    'credit' => $amount,
                    'remarks' => $remarks ?: 'Profit withdraw',
                    'type' => 'profit_withdraw',
                    'status' => 1,
                    'date' => $date,
                ];
                $this->adddata('ledger', $ledger);
                $_SESSION['msg'] = 'Profit withdraw saved successfully';
            } else {
                $_SESSION['msg'] = 'Please select investor and valid amount for profit withdraw';
            }
            $this->redirect($this->refpg());
        }

        if ($profit_amount <= 0) {
            $_SESSION['msg'] = 'Please enter a valid profit amount';
            $this->redirect($this->refpg());
        }

        $investors = $this->getdata("select investor_id, sum(debit) as total_debit, sum(credit) as total_credit from ledger where type in ('invest','invest_withdraw') and status = 1 group by investor_id");
        $eligible = [];
        $total_balance = 0;

        foreach ($investors as $v) {
            $balance = (float) $v['total_debit'] - (float) $v['total_credit'];
            if ($balance > 0) {
                $eligible[] = ['investor_id' => $v['investor_id'], 'balance' => $balance];
                $total_balance += $balance;
            }
        }

        if (empty($eligible) || $total_balance <= 0) {
            $_SESSION['msg'] = 'No investor balance found for profit distribution';
            $this->redirect($this->refpg());
        }

        $group_id = 'PROFIT-' . date('YmdHis') . '-' . rand(100, 999);
        $created = 0;

        foreach ($eligible as $v) {
            $share = $profit_amount * ($v['balance'] / $total_balance);
            if ($share <= 0) {
                continue;
            }

            $ledger = [
                'group_id' => $group_id,
                'investor_id' => $v['investor_id'],
                'debit' => 0,
                'credit' => $share,
                'remarks' => $remarks ?: 'Profit distribution',
                'type' => 'profit_generate',
                'status' => 1,
                'date' => $date,
            ];

            $this->adddata('ledger', $ledger);
            $created++;
        }

        $_SESSION['msg'] = $created > 0 ? 'Profit generated successfully' : 'No profit rows created';
        $this->redirect($this->refpg());
    }

    if (isset($_GET['del_profit'])) {
        if ($this->delete('delete from ledger where id ='.$_GET['del_profit'].' and type in ("profit_generate","profit_withdraw")')) {
            $_SESSION['msg'] = 'Profit entry deleted successfully';
        } else {
            $_SESSION['msg'] = 'Delete failed';
        }
        $this->redirect($this->refpg());
    }
}

}
