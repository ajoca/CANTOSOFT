<?php
/*
  ###########################################################
  # PRODUCT NAME: 	iRestora PLUS - Next Gen Restaurant POS
  ###########################################################
  # AUTHER:		Doorsoft
  ###########################################################
  # EMAIL:		info@doorsoft.co
  ###########################################################
  # COPYRIGHTS:		RESERVED BY Door Soft
  ###########################################################
  # WEBSITE:		http://www.doorsoft.co
  ###########################################################
  # This is Sale Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Sale_model');
        $this->load->model('Kitchen_model');
        $this->load->model('Waiter_model');
        $this->load->model('Master_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        if (!$this->session->has_userdata('user_id') && $this->session->has_userdata('is_online_order')!="Yes") {
            redirect('Authentication/index');
        }

        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2', 'Please click on green Enter button of an outlet');
            redirect('Outlet/outlets');
        }
        // pre($this->session->userdata());exit;
        $is_waiter = $this->session->userdata('is_waiter');
        $designation = $this->session->userdata('designation');
        //check register is open or not
        if($designation!="Waiter" && $this->session->has_userdata('is_online_order')!="Yes" && !isFoodCourt()){
            $user_id = $this->session->userdata('user_id');
            $outlet_id = $this->session->userdata('outlet_id');
            if($this->Common_model->isOpenRegister($user_id,$outlet_id)==0){
                $this->session->set_flashdata('exception_3', lang('register_open_msg'));
                if($this->uri->segment(2)=='registerDetailCalculationToShowAjax' || $this->uri->segment(2)=='closeRegister'){
                    redirect('Register/openRegister');
                }else{
                    $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
                    $this->session->set_userdata("clicked_method", $this->uri->segment(2));
                    redirect('Register/openRegister');
                }

            }
        }

        $login_session['active_menu_tmp'] = '';
        $this->session->set_userdata($login_session);
    }

     /**
     * sales info
     * @access public
     * @return void
     * @param no
     */
    public function sales($id='') {
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "123";
        $function = "";

        if($segment_2=="sales"){
            $function = "view";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function


        $outlet_id = $this->session->userdata('outlet_id');
        $data = array();
        $data['edit_return_id'] = $id;
        $data['main_content'] = $this->load->view('sale/sales', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    public function refund($encrypted_id = "") {
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "123";
        $function = "";

        if($segment_2=="refund"){
            $function = "refund";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function

        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $purchase_info = array();
        if (htmlspecialcharscustom($this->input->post('submit'))) {

            $this->form_validation->set_rules('total_refund', lang('total_refund'), 'required|max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $purchase_info['counter_id'] = $this->session->userdata('counter_id');
                $purchase_info['refund_date_time'] = date('Y-m-d H:i:s');
                $purchase_info['refund_payment_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('payment_id')));
                $purchase_info['total_refund'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('total_refund')));
                $this->Common_model->updateInformation($purchase_info, $id, "tbl_sales");
                /*This variable could not be escaped because this is an array field*/
                $this->saveRefundItems($_POST['qty'], $id, 'tbl_sales_details');
                $this->session->set_flashdata('exception',lang('update_success'));

                redirect('Sale/sales');
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['sale'] = $this->Common_model->getDataById($id, "tbl_sales");
                $data['sale_details'] = $this->Sale_model->getAllItemsFromSalesDetailBySalesId($id);
                $data['main_content'] = $this->load->view('sale/refund', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['encrypted_id'] = $encrypted_id;
            $data['sale'] = $this->Common_model->getDataById($id, "tbl_sales");
            $data['sale_details'] = $this->Sale_model->getAllItemsFromSalesDetailBySalesId($id);
            $data['main_content'] = $this->load->view('sale/refund', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }
    public function saveRefundItems($qtys, $sale_id, $table_name) {
        $main_arry = array();
        $tmp_txt ="<br><b>Items:</b><br>";
        foreach ($qtys as $row => $qty):
            /*This all variables could not be escaped because this is an array field*/
            $fmi = array();
            $fmi['qty'] = $qty;
            $fmi['item_id'] = $_POST['item_id'][$row];
            $fmi['name'] = $_POST['name'][$row];
            $fmi['price'] = $_POST['price'][$row];
            $fmi['vat'] = $_POST['vat'][$row];
            $fmi['discount'] = $_POST['discount'][$row];
            $fmi['refund_qty'] = $_POST['refund_qty'][$row];
            $main_arry[] = $fmi;
            $price = $_POST['price'][$row];
            $tmp_txt.=$_POST['name'][$row]."("."$qty X $price".")";

            if($row < (sizeof($qtys) -1)){
                $tmp_txt.=", ";
            }

        endforeach;
        $sale['refund_content'] = json_encode($main_arry);
        $this->Common_model->updateInformation($sale, $sale_id, "tbl_sales");

        $txt = '';
        $sale = $this->Common_model->getDataById($sale_id, "tbl_sales");
        $customer_info = getCustomerData($sale->customer_id);
        $txt.="Sale No: ".$sale->sale_no.", ";
        $txt.="Sale Date: ".date($this->session->userdata('date_format'), strtotime($sale->sale_date)).", ";
        $txt.="Refund Date: ".date($this->session->userdata('date_format'), strtotime($sale->refund_date_time)).", ";
        $txt.="Customer: ".(isset($customer_info) && $customer_info->name?$customer_info->name:'---')." - ".(isset($customer_info) && $customer_info->phone?$customer_info->phone:'').", ";
        $txt.="Total Payable: ".$sale->total_payable.", ";
        $txt.="Total Refund: ".$sale->total_refund;
        $txt.=$tmp_txt;
        putAuditLog($this->session->userdata('user_id'),$txt,"Refund Sale",date('Y-m-d H:i:s'));
    }
    public function getDetailsRefund()
    {
        $sale_id = $this->input->post('sale_id');
        $sale = $this->Common_model->getDataById($sale_id, "tbl_sales");
        $html = '';
        $g_total = 0;
        $sale_json = (Object)json_decode($sale->refund_content);
        if ($sale_json && !empty($sale_json)) {
            foreach ($sale_json as $pi) {
                $total = ((float)$pi->price*(float)$pi->refund_qty) - ($pi->discount?$pi->discount:0) + ((float)$pi->vat*(float)$pi->refund_qty);
                $html .= '<tr class="rowCount">
                                            <td>'.$pi->name.'</td>
                                            <td>'.$pi->qty.'</td>
                                            <td>'.getAmtP($pi->price).'</td>
                                            <td>'.getAmtP($pi->vat).'</td>
                                            <td>'.getAmtP($pi->discount).'</td>
                                            <td>'.$pi->refund_qty.'</td>
                                            <td>'.getAmtP($total).'</td>
                                        </tr>';
                $g_total+=$total;
            }
            $html .= '<tr class="rowCount">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <th class="pull-right">'.lang("total").'=</th>
                                            <th>'.getAmtP($g_total).'</th>
                                        </tr>';
        }
        //This variable could not be escaped because this is html content
        $return['refund_date_time'] = $sale->refund_date_time;
        $return['html'] = $html;
        echo json_encode($return);
    }
     /**
     * sales info
     * @access public
     * @return void
     * @param no
     */
    public function exportDailySales() {
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "123";
        $function = "";

        if($segment_2=="exportDailySales"){
            $function = "exportDailySales";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function

        $fileName = 'Sale Data-'.(date("Y-m-d")).'.xlsx';

        // load excel library
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', lang('customer'));
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', lang('date'));
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', lang('reference'));
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', lang('items'));
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', lang('subtotal'));
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', lang('discount'));
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', lang('vat'));
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', lang('g_total'));
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', lang('payment_method'));
        // set Row
        $rowCount = 2;
        $sales = $this->Sale_model->exportDailySale();
        foreach ($sales as $key=>$value){
            $items = '';
            $details = $this->Sale_model->getAllItemsFromSalesDetailBySalesId($value->id);
            foreach ($details as $key1=>$value1){
                $items.= $value1->menu_name." X ".$value1->qty;
                if($key1 < (sizeof($details) -1)){
                    $items.= "\n";
                }
            }
            $payment_details = '';
            $outlet_id = $this->session->userdata('outlet_id');
            $salePaymentDetails = salePaymentDetails($value->id,$outlet_id);
            if(isset($salePaymentDetails) && $salePaymentDetails):
                ?>
                <?php foreach ($salePaymentDetails as $ky=>$payment):
                $txt_point = '';
                if($payment->id==5){
                    $txt_point = " (Usage Point:".$payment->usage_point.")";
                }
                $payment_details.= escape_output($payment->payment_name.$txt_point).":".escape_output(getAmtPCustom($payment->amount));
                if($ky<sizeof($salePaymentDetails)-1){
                    $payment_details.=" - ";
                }
            endforeach;
            endif;


            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, escape_output($value->customer_name));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, escape_output(date($this->session->userdata('date_format'), strtotime($value->sale_date))));
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, escape_output($value->sale_no));
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $items);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, escape_output(getAmtP($value->sub_total)));
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, escape_output(getAmtP($value->total_discount_amount)));
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, escape_output(getAmtP($value->vat)));
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, escape_output(getAmtP($value->total_payable)));
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, escape_output($payment_details));
            $rowCount++;
        }
        $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);
        $objWriter  = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save("asset/excel/".$fileName);
        // download file
        header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."asset/excel/".$fileName);
    }

    /**
     * reset Daily Sales Data
     * @access public
     * @return void
     * @param no
     */
    public function resetDailySales() {
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "123";
        $function = "";

        if($segment_2=="resetDailySales"){
            $function = "resetDailySales";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function
        //truncate all transactional data
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->delete('tbl_sales', array('outlet_id ' => $outlet_id));
        $this->db->delete('tbl_sales_details', array('outlet_id ' => $outlet_id));
        $this->db->delete('tbl_sales_details_modifiers', array('outlet_id ' => $outlet_id));
        $this->db->delete('tbl_sale_consumptions', array('outlet_id ' => $outlet_id));
        $this->db->delete('tbl_sale_consumptions_of_menus', array('outlet_id ' => $outlet_id));
        $this->db->delete('tbl_sale_consumptions_of_modifiers_of_menus', array('outlet_id ' => $outlet_id));
        $this->db->delete('tbl_sale_payments', array('outlet_id ' => $outlet_id));
        $this->db->delete('tbl_kitchen_sales', array('outlet_id ' => $outlet_id));
        $this->db->delete('tbl_kitchen_sales_details', array('outlet_id ' => $outlet_id));
        $this->db->delete('tbl_kitchen_sales_details_modifiers', array('outlet_id ' => $outlet_id));
        
        $this->session->set_flashdata('exception', lang('truncate_sale_update_success'));
        redirect('Sale/sales');
    }
     /**
     * delete Sale
     * @access public
     * @return void
     * @param int
     */
    public function deleteSale($id) {
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "123";
        $function = "";

        if($segment_2=="deleteSale"){
            $function = "delete";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function

        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $event_txt = getSaleText($id);
        putAuditLog($this->session->userdata('user_id'),$event_txt,"Deleted Sale",date('Y-m-d H:i:s'));

        $isDeleted = $this->delete_specific_order_by_sale_id($id);
        if($isDeleted){
            $this->session->set_flashdata('exception', 'Information has been deleted successfully!');
            redirect('Sale/sales');
        }else{
            $this->session->set_flashdata('exception_2', 'Something went wrong!');
            redirect('Sale/sales');
        }

    }
     /**
     * POS screen
     * @access public
     * @return void
     * @param int
     */
    public function POS($user_id='', $outlet_id='',$sale_id=""){
        $is_waiter = $this->session->userdata('is_waiter');
        $counter_id = $this->session->userdata('counter_id');
        $company_id = $this->session->userdata('company_id');
        $is_self_order = $this->session->userdata('is_self_order');
        $is_online_order = $this->session->userdata('is_online_order');
        if($is_self_order=="Yes" && !$outlet_id){
            echo "<h1 style='color:red;padding:10px;text-align:center'>".lang('self_order_scan_error')."</h1>";exit;
        }

        if($is_self_order=="Yes"){
            $company = $this->Common_model->getDataById($company_id, "tbl_companies");
              if(isset($company) && $company->sos_enable_self_order == "No"){
                    echo "<h1 style='color:red;padding:10px;text-align:center'>".lang('self_order_scan_error_1')."</h1>";exit;
              }
        }
       
        if($counter_id){
                   $counter_details = $this->Common_model->getPrinterIdByCounterId($counter_id);
                   $printer_info = $this->Common_model->getPrinterInfoById($counter_details->invoice_printer_id);
                   $print_arr = [];
                   $print_arr['counter_id'] = $counter_id;
                   $print_arr['printer_id'] = $counter_details->invoice_printer_id;
                   if($printer_info){
                        $print_arr['path'] = $printer_info->path;
                        $print_arr['title'] = $printer_info->title;
                        $print_arr['type'] = $printer_info->type;
                        $print_arr['characters_per_line'] = $printer_info->characters_per_line;
                        $print_arr['printer_ip_address'] = $printer_info->printer_ip_address;
                        $print_arr['printer_port'] = $printer_info->printer_port;
                        $print_arr['printing_choice'] = $printer_info->printing_choice;
                        $print_arr['ipvfour_address'] = $printer_info->ipvfour_address;
                        $print_arr['print_format'] = $printer_info->print_format;
                        $print_arr['inv_qr_code_enable_status'] = $printer_info->inv_qr_code_enable_status;
                   }
                   //bill
                   $printer_info_bill = $this->Common_model->getPrinterInfoById($counter_details->bill_printer_id);
              
                   $print_arr['bill_printer_id'] = $counter_details->bill_printer_id;
                   if($printer_info_bill){
                        $print_arr['path_bill'] = $printer_info_bill->path;
                        $print_arr['title_bill'] = $printer_info_bill->title;
                        $print_arr['type_bill'] = $printer_info_bill->type;
                        $print_arr['characters_per_line_bill'] = $printer_info_bill->characters_per_line;
                        $print_arr['printer_ip_address_bill'] = $printer_info_bill->printer_ip_address;
                        $print_arr['printer_port_bill'] = $printer_info_bill->printer_port;
                        $print_arr['printing_choice_bill'] = $printer_info_bill->printing_choice;
                        $print_arr['ipvfour_address_bill'] = $printer_info_bill->ipvfour_address;
                        $print_arr['print_format_bill'] = $printer_info_bill->print_format;
                        $print_arr['inv_qr_code_enable_status_bill'] = $printer_info_bill->inv_qr_code_enable_status;
                   }
                   $this->session->set_userdata($print_arr);
        }

       

        if(!$user_id || !$outlet_id){
            redirect('POSChecker/posAndWaiterMiddleman');
        }


        if(isServiceAccessOnly('sGmsJaFJE')){
            if($sale_id==''){
                if(!checkCreatePermissionInvoice()){
                    $this->session->set_flashdata('exception_1',lang('not_permission_invoice_create_error'));
                    redirect("Sale/sales");
                }
            }

        }
        
        $company_id = $this->session->userdata('company_id');

        $outlet_id = $this->session->userdata('outlet_id');

        $data = array();
        $data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customers');
        $data['food_menus'] = $this->Sale_model->getAllFoodMenus();
        if(isset($data['food_menus']) && $data['food_menus']){
            foreach ($data['food_menus'] as $key=>$value){
                $variations = $this->Common_model->getAllByCustomId($value->id,"parent_id","tbl_food_menus",$order='');
                $data['food_menus'][$key]->is_variation = isset($variations) && $variations?'Yes':'No';
                $data['food_menus'][$key]->variations = $variations;
                    $kitchen = getKitchenNameAndId($value->category_id);
                    $data['food_menus'][$key]->kitchen_id =$kitchen[0];
                    $data['food_menus'][$key]->kitchen_name =$kitchen[1];
            }
        }
        $data['denominations'] = $this->Common_model->getDenomination($company_id);
        $data['menu_categories'] = $this->Common_model->getSortingForPOS();
        $data['menu_modifiers'] = $this->Sale_model->getAllMenuModifiers();
        $data['waiters'] = $this->Sale_model->getWaitersForThisCompany($company_id,'tbl_users');
        $data['MultipleCurrencies'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_multiple_currencies");
        $data['users'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_users");
        $data['outlet_information'] = $this->Common_model->getDataById($outlet_id, "tbl_outlets");
        $data['payment_methods'] = $this->Sale_model->getAllPaymentMethods();
        $data['payment_method_finalize'] = $this->Sale_model->getAllPaymentMethodsFinalize();
        $data['deliveryPartners'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_delivery_partners");
        $data['areas'] = $this->Common_model->getAllByOutletId($outlet_id, 'tbl_areas');
        $data['only_modifiers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_modifiers');
        $data['kitchens'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_kitchens");
        $data['notifications'] = $this->get_new_notification();
        $data['sale_details'] = $this->Common_model->getDataById($sale_id, "tbl_sales");
        $this->load->view('sale/POS/main_screen', $data);
    }

    public function getKitchenStatus()
        {
            $table_id = $this->input->post('table_id');
            $this->db->select("tbl_kitchen_sales.is_merge,tbl_kitchen_sales.self_order_content,tbl_kitchen_sales.id as sale_id,tbl_kitchen_sales.sale_no,tbl_kitchen_sales.waiter_id,tbl_kitchen_sales.total_payable,tbl_kitchen_sales_details.menu_name, tbl_kitchen_sales_details.qty, tbl_kitchen_sales_details.cooking_status,tbl_kitchen_sales_details.cooking_start_time,tbl_kitchen_sales_details.cooking_done_time");
            $this->db->from('tbl_kitchen_sales_details');
            $this->db->join('tbl_kitchen_sales', 'tbl_kitchen_sales.id = tbl_kitchen_sales_details.sales_id', 'left');
            $this->db->where("tbl_kitchen_sales.table_id", $table_id);
            $this->db->where("tbl_kitchen_sales_details.del_status", "Live");
            $data =  $this->db->get()->result();
          
            $return_josn = array();
            $str = '';
            $sale_no = '';
            $total_payable = 0;
            $sale_id = 0;
            $waiter_id = 0;
            $is_merge = 0;
            $self_order_content = '';
            if(isset($data) && $data){
                $str .= "<br>".lang('kitchen_status').":<hr>";
                $i  =1;
                foreach($data as $value){
                    $times = '';
                    $self_order_content = $value->self_order_content;
                    $is_merge = $value->is_merge;
                    $sale_no = $value->sale_no;
                    $total_payable = $value->total_payable;
                    $sale_id = $value->sale_id;
                    $waiter_id = $value->waiter_id;
                    if($value->cooking_status=="Done"){
                        $times = timeElapsed($value->cooking_done_time);
                    }
        
                    if($value->cooking_status=="Started Cooking"){
                        $times = timeElapsed($value->cooking_start_time);
                    }
                    $str.= "#".$i." ".$value->menu_name."-".$value->qty." Qty, Status: (".$value->cooking_status." ".$times.")<br>";
                    $i++;
                }
            }
        
             $return_josn['html_content'] = $str;
             $return_josn['self_order_content'] = $self_order_content;
             $return_josn['sale_id'] = $sale_id;
             $return_josn['order_number'] = $sale_no;
             $return_josn['is_merge'] = $is_merge;
             $return_josn['waiter_name'] = userName($waiter_id);
             $return_josn['total_payable'] = getAmtCustom($total_payable);
             $return_josn['html_content'] = $str;
             echo (json_encode($return_josn));
        }

     /**
     * get Tables Details
     * @access public
     * @return object
     * @param string
     */
    public function getTablesDetails($tables){
        foreach($tables as $table){
            $table->orders_table = $this->Sale_model->getOrdersOfTableByTableId($table->id);
            foreach($table->orders_table as $order_table){

                $to_time = strtotime(date('Y-m-d H:i:s'));
                $from_time = strtotime($order_table->booking_time);
                $minutes = floor(abs($to_time - $from_time) / 60);
                $seconds = abs($to_time - $from_time) % 60;

                $order_table->booked_in_minute = $minutes;
            }
        }
        return $tables;
    }
     /**
     * Save sales data
     * @access public
     * @return void
     * @param no
     */
    public function Save() {
        $data = array();
        $data['customer_id'] = $this->input->get('customer_id');
        $data['total_items'] = $this->input->get('total_items');
        $data['sub_total'] = $this->input->get('sub_total');
        $data['disc'] = $this->input->get('disc');
        $data['disc_actual'] = $this->input->get('disc_actual');
        $data['vat'] = $this->input->get('vat');
        $data['paid_amount'] = $this->input->get('paid_amount');
        $data['due_amount'] = $this->input->get('due_amount');
        $data['table_id'] = $this->input->get('table_id');
        $data['token_no'] = $this->input->get('token_no');
        if ($this->input->get('due_payment_date')) {
            $data['due_payment_date'] = $this->input->get('due_payment_date');
        } else {
            $data['due_payment_date'] = Null;
        }

        $data['total_payable'] = $this->input->get('total_payable');
        $data['payment_method_id'] = $this->input->get('payment_method_id');
        $data['user_id'] = $this->session->userdata('user_id');
        $data['outlet_id'] = $this->session->userdata('outlet_id');
        $data['sale_date'] = $this->input->get('sale_date');
        $data['sale_time'] = date('h:i A');
        $outlet_id = $this->session->userdata('outlet_id');
        $sale_no = $this->db->query("SELECT count(id) as bno
               FROM tbl_sales WHERE outlet_id=$outlet_id")->row('bno');
        $sale_no = str_pad($sale_no + 1, 6, '0', STR_PAD_LEFT);
        $data['sale_no'] = $sale_no;
        ////////////
        $food_menu_id = $this->input->get('food_menu_id');
        $menu_name = $this->input->get('menu_name');
        $price = $this->input->get('price');
        $qty = $this->input->get('qty');
        $discount_amount = $this->input->get('discountNHiddenTotal');
        $total = $this->input->get('total');
        /////////////////////
        $i = 0;
        $this->db->trans_begin();
        $query = $this->db->insert('tbl_sales', $data);
        $sales_id = $this->db->insert_id();

        $comsump = array();
        $comsump['outlet_id'] = $this->session->userdata('outlet_id');
        $comsump['date'] = date('Y-m-d');
        $comsump['date_time'] = date('h:i A');
        $comsump['user_id'] = $this->session->userdata('user_id');
        $comsump['sale_id'] = $sales_id;
        $query = $this->db->insert('tbl_sale_consumptions', $comsump);
        $sale_consumption_id = $this->db->insert_id();

        //////////////////////////////////
        foreach ($food_menu_id as $value) {
            $data1['food_menu_id'] = $value;
            $data1['sales_id'] = $sales_id;
            $data1['menu_name'] = $menu_name[$i];
            $data1['price'] = $price[$i];
            $data1['qty'] = $qty[$i];
            $data1['discount_amount'] = $discount_amount[$i];
            $data1['total'] = $total[$i];
            $data1['user_id'] = $this->session->userdata('user_id');
            $data1['outlet_id'] = $this->session->userdata('outlet_id');
            $data1['cooking_status'] = 'New';
            $this->db->insert('tbl_sales_details', $data1);
            //////////////////////

            $ingredlist = $this->Sale_model->getFoodMenuIngredients($value);
            foreach ($ingredlist as $inrow) {
                $data3 = array();
                $data3['sale_consumption_id'] = $sale_consumption_id;
                $data3['ingredient_id'] = $inrow->ingredient_id;
                $data3['consumption'] = $inrow->consumption * $qty[$i];
                $data3['user_id'] = $this->session->userdata('user_id');
                $data3['outlet_id'] = $this->session->userdata('outlet_id');
                $this->db->insert('tbl_sale_consumptions_of_menus', $data3);
            }
            //////////////////////
            $i++;
        }
        $returndata = array('sales_id' => $sales_id);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            echo json_encode($returndata);
            $this->db->trans_commit();
        }
    }
     /**
     * delete Suspend
     * @access public
     * @return object
     * @param no
     */
    public function deleteSuspend() {
        $suspendID = $this->input->get('minusSuspendID');
        $this->session->unset_userdata('customer_id_' . $suspendID);
        $this->session->unset_userdata('total_item_hidden_' . $suspendID);
        $this->session->unset_userdata('sub_total_' . $suspendID);
        $this->session->unset_userdata('disc_' . $suspendID);
        $this->session->unset_userdata('disc_actual_' . $suspendID);
        $this->session->unset_userdata('vat_' . $suspendID);
        $this->session->unset_userdata('gTotalDisc_' . $suspendID);
        $this->session->unset_userdata('total_payable_' . $suspendID);
        $this->session->unset_userdata('tables_' . $suspendID);
        $this->session->unset_userdata('countSuspend_' . $suspendID);
        $this->session->unset_userdata('countTimeSuspend_' . $suspendID);
        $this->session->unset_userdata('countSuspendCurrent');
        echo json_encode("success");
    }
     /**
     * get Suspend
     * @access public
     * @return object
     * @param no
     */
    public function getSuspend() {
        $suspendID = $this->input->get('suspendID');
        $checkSuspend = $this->session->userdata('countSuspend_' . $suspendID);
        if ($checkSuspend) {
            $data['status'] = true;
            $data['sus_id'] = $suspendID;
            $data['customer_id'] = $this->session->userdata('customer_id_' . $suspendID);
            $data['total_item_hidden'] = $this->session->userdata('total_item_hidden_' . $suspendID);
            $data['sub_total'] = $this->session->userdata('sub_total_' . $suspendID);
            $data['disc'] = $this->session->userdata('disc_' . $suspendID);
            $data['disc_actual'] = $this->session->userdata('disc_actual_' . $suspendID);
            $data['gTotalDisc'] = $this->session->userdata('gTotalDisc_' . $suspendID);
            $data['vat'] = $this->session->userdata('vat_' . $suspendID);
            $data['total_payable'] = $this->session->userdata('total_payable_' . $suspendID);
            $data['tables'] = $this->session->userdata('tables_' . $suspendID);
        } else {
            $data['status'] = false;
        }
        echo json_encode($data);
    }
     /**
     * get Suspend Current
     * @access public
     * @return object
     * @param no
     */
    public function getSuspendCurrent() {

        $checkSuspend = $this->session->userdata('countSuspendCurrent');
        $suspendID = "current";

        $data['status'] = true;
        $data['customer_id'] = $this->session->userdata('customer_id_' . $suspendID);
        $data['total_item_hidden'] = $this->session->userdata('total_item_hidden_' . $suspendID);
        $data['sub_total'] = $this->session->userdata('sub_total_' . $suspendID);
        $data['disc'] = $this->session->userdata('disc_' . $suspendID);
        $data['disc_actual'] = $this->session->userdata('disc_actual_' . $suspendID);
        $data['vat'] = $this->session->userdata('vat_' . $suspendID);
        $data['gTotalDisc'] = $this->session->userdata('gTotalDisc_' . $suspendID);
        $data['total_payable'] = $this->session->userdata('total_payable_' . $suspendID);
        $data['tables'] = $this->session->userdata('tables_' . $suspendID);
        echo json_encode($data);
    }
     /**
     * set Suspend
     * @access public
     * @return object
     * @param no
     */
    public function setSuspend() {
        $check1 = $this->session->userdata('countSuspend_1');
        $check2 = $this->session->userdata('countSuspend_2');
        $check3 = $this->session->userdata('countSuspend_3');

        $checkTime1 = $this->session->userdata('countTimeSuspend_1');
        $checkTime2 = $this->session->userdata('countTimeSuspend_2');
        $checkTime3 = $this->session->userdata('countTimeSuspend_3');

        $times = date('Y-m-d h:i:s');

        if (!$check1) {
            $temp = 1;
            $this->session->set_userdata('countSuspend_1', 1);
            $this->session->set_userdata('countTimeSuspend_1', $times);
        } elseif (!$check2) {
            $temp = 2;
            $this->session->set_userdata('countSuspend_2', 2);
            $this->session->set_userdata('countTimeSuspend_2', $times);
        } elseif (!$check3) {
            $this->session->set_userdata('countSuspend_3', 3);
            $this->session->set_userdata('countTimeSuspend_3', $times);
            $temp = 3;
        } else {

            if ($checkTime1 < $checkTime2) {
                if ($checkTime1 < $checkTime3) {
                    $temp = 1;
                    $this->session->unset_userdata('countSuspend_' . $temp);
                    $this->session->set_userdata('countSuspend_1', 1);
                    $this->session->unset_userdata('countTimeSuspend_' . $temp);
                    $this->session->set_userdata('countTimeSuspend_1', $times);
                } else {
                    $temp = 3;
                    $this->session->unset_userdata('countSuspend_' . $temp);
                    $this->session->set_userdata('countSuspend_3', 3);
                    $this->session->unset_userdata('countTimeSuspend_' . $temp);
                    $this->session->set_userdata('countTimeSuspend_3', $times);
                }
            } else {
                if ($checkTime2 < $checkTime3) {
                    $temp = 2;
                    $this->session->unset_userdata('countSuspend_' . $temp);
                    $this->session->set_userdata('countSuspend_2', 2);
                    $this->session->unset_userdata('countTimeSuspend_' . $temp);
                    $this->session->set_userdata('countTimeSuspend_2', $times);
                } else {
                    $temp = 3;
                    $this->session->unset_userdata('countSuspend_' . $temp);
                    $this->session->set_userdata('countSuspend_3', 3);
                    $this->session->unset_userdata('countTimeSuspend_' . $temp);
                    $this->session->set_userdata('countTimeSuspend_3', $times);
                }
            }
        }

        //set session value
        $i = 0;
        $food_menu_id = $this->input->get('food_menu_id');
        $menu_name = $this->input->get('menu_name');
        $price = $this->input->get('price');
        $qty = $this->input->get('qty');
        $VATHidden = $this->input->get('VATHidden');
        $VATHiddenTotal = $this->input->get('VATHiddenTotal');
        $discountN = $this->input->get('discountN');
        $discountNHidden = $this->input->get('discountNHidden');
        $discountNHiddenTotal = $this->input->get('discountNHiddenTotal');
        $total = $this->input->get('total');
        $tableRow = "";
        foreach ($food_menu_id as $value) {
            $trID = "row_" . $i;
            $inputID = "food_menu_id_" . $i;
            $tableRow .= "<tr data-id='$i' class='clRow' id='row_$i'><input id='food_menu_id_$i' name='food_menu_id[]' value='$value' type='hidden'><input id='$inputID' name='menu_name[]' value='$menu_name[$i]' type='hidden'><input id='discountNHidden_$i' name='discountNHidden[]' value='$discountNHidden[$i]' type='hidden'><input id='discountNHiddenTotal_$i' name='discountNHiddenTotal[]' value='$discountNHiddenTotal[$i]' type='hidden'><input id='VATHidden_$i' name='VATHidden[]' value='$VATHidden[$i]' type='hidden'><input id='VATHiddenTotal_$i' name='VATHiddenTotal[]' value='$VATHiddenTotal[$i]' type='hidden'><td>$menu_name[$i]</td><td><input class='pri-size txtboxToFilter' onfocus='this.select();' id='price_$i' name='price[]' value='$price[$i]' onblur='return calculateRow($i);' onkeyup='return calculateRow($i)' type='text'></td><td><input class='qty-size txtboxToFilter' onfocus='this.select();' min='1' id='qty_$i' name='qty[]' value='$qty[$i]' onmouseup='return helloThere($i)' onblur='return calculateRow($i);' onkeyup='return checkQuantity($i);' onkeydown='return calculateRow($i);' type='number'></td><td><input class='qty-size discount' onfocus='this.select();'  id='discountN_$i' name='discountN[]' value='$discountN[$i]' onmouseup='return helloThere($i)' onblur='return calculateRow($i);' onkeyup='return checkQuantity($i);' onkeydown='return calculateRow($i);' type='text'></td><td><input class='pri-size' readonly='' id='total_$i' name='total[]' style='background-color: #dddddd;border:1px solid #7e7f7f;' value='$total[$i]' type='text'></td><td style='text-align: center'><a class='btn btn-danger btn-xs' onclick='return deleter($i,$value);'><i style='color:white' class='fa fa-trash'></i></a></td></tr>";
            $i++;
        }
        $customer_id = $this->input->get('customer_id');
        $total_item_hidden = $this->input->get('total_items');
        $sub_total = $this->input->get('sub_total');
        $disc = $this->input->get('disc');
        $disc_actual = $this->input->get('disc_actual');
        $vat = $this->input->get('vat');
        $gTotalDisc = $this->input->get('gTotalDisc');
        $total_payable = $this->input->get('total_payable');
        $tables = $tableRow;
        $this->session->set_userdata('customer_id_' . $temp, $customer_id);
        $this->session->set_userdata('total_item_hidden_' . $temp, $total_item_hidden);
        $this->session->set_userdata('sub_total_' . $temp, $sub_total);
        $this->session->set_userdata('disc_' . $temp, $disc);
        $this->session->set_userdata('disc_actual_' . $temp, $disc_actual);
        $this->session->set_userdata('vat_' . $temp, $vat);
        $this->session->set_userdata('gTotalDisc_' . $temp, $gTotalDisc);
        $this->session->set_userdata('total_payable_' . $temp, $total_payable);
        $this->session->set_userdata('tables_' . $temp, $tables);
        $data['suspend_id'] = $temp;
        echo json_encode($data);
    }
     /**
     * set Suspend Current
     * @access public
     * @return object
     * @param no
     */
    public function setSuspendCurrent() {

        $currentStatus = $this->input->get('currentStatus');
        if ($currentStatus == "1") {
            $temp = "current";
            $this->session->set_userdata('countSuspendCurrent', 1);
            //set session value
            $i = 0;
            $ingredient_id = $this->input->get('ingredient_id');
            $menu_name = $this->input->get('menu_name');
            $price = $this->input->get('price');
            $qty = $this->input->get('qty');
            $VATHidden = $this->input->get('VATHidden');
            $VATHiddenTotal = $this->input->get('VATHiddenTotal');
            $discountN = $this->input->get('discountN');
            $discountNHidden = $this->input->get('discountNHidden');
            $discountNHiddenTotal = $this->input->get('discountNHiddenTotal');
            $total = $this->input->get('total');
            $tableRow = "";
            foreach ($ingredient_id as $value) {
                $trID = "row_" . $i;
                $inputID = "ingredient_id_" . $i;
                $tableRow .= "<tr data-id='$i' class='clRow' id='row_$i'><input id='ingredient_id_$i' name='ingredient_id[]' value='$value' type='hidden'><input id='$inputID' name='menu_name[]' value='$menu_name[$i]' type='hidden'><input id='discountNHidden_$i' name='discountNHidden[]' value='$discountNHidden[$i]' type='hidden'><input id='discountNHiddenTotal_$i' name='discountNHiddenTotal[]' value='$discountNHiddenTotal[$i]' type='hidden'><input id='VATHidden_$i' name='VATHidden[]' value='$VATHidden[$i]' type='hidden'><input id='VATHiddenTotal_$i' name='VATHiddenTotal[]' value='$VATHiddenTotal[$i]' type='hidden'><td>$menu_name[$i]</td><td><input class='pri-size txtboxToFilter' onfocus='this.select();' id='price_$i' name='price[]' value='$price[$i]' onblur='return calculateRow($i);' onkeyup='return calculateRow($i)' type='text'></td><td><input class='qty-size txtboxToFilter' onfocus='this.select();' min='1' id='qty_$i' name='qty[]' value='$qty[$i]' onmouseup='return helloThere($i)' onblur='return calculateRow($i);' onkeyup='return checkQuantity($i);' onkeydown='return calculateRow($i);' type='number'></td><td><input class='qty-size discount' onfocus='this.select();'  id='discountN_$i' name='discountN[]' value='$discountN[$i]' onmouseup='return helloThere($i)' onblur='return calculateRow($i);' onkeyup='return checkQuantity($i);' onkeydown='return calculateRow($i);' type='text'></td><td><input class='pri-size' readonly='' id='total_$i' name='total[]' style='background-color: #dddddd;border:1px solid #7e7f7f;' value='$total[$i]' type='text'></td><td style='text-align: center'><a class='btn btn-danger btn-xs' onclick='return deleter($i,$value);'><i style='color:white' class='fa fa-trash'></i></a></td></tr>";
                $i++;
            }
            $customer_id = $this->input->get('customer_id');
            $total_item_hidden = $this->input->get('total_items');
            $sub_total = $this->input->get('sub_total');
            $disc = $this->input->get('disc');
            $disc_actual = $this->input->get('disc_actual');
            $vat = $this->input->get('vat');
            $total_payable = $this->input->get('total_payable');
            $tables = $tableRow;

            $this->session->set_userdata('customer_id_' . $temp, $customer_id);
            $this->session->set_userdata('total_item_hidden_' . $temp, $total_item_hidden);
            $this->session->set_userdata('sub_total_' . $temp, $sub_total);
            $this->session->set_userdata('disc_' . $temp, $disc);
            $this->session->set_userdata('disc_actual_' . $temp, $disc_actual);
            $this->session->set_userdata('vat_' . $temp, $vat);
            $this->session->set_userdata('total_payable_' . $temp, $total_payable);
            $this->session->set_userdata('tables_' . $temp, $tables);
            $data['suspend_id'] = $temp;

            echo json_encode($data);
        }
    }
     /**
     * set Service Session
     * @access public
     * @return object
     * @param no
     */
    public function setServiceSession() {
        $serviceValue = $this->input->get('serviceValue');
        $this->session->set_userdata('serviceSession', $serviceValue);
    }
     /**
     * get Service Session
     * @access public
     * @return object
     * @param no
     */
    public function getServiceSession() {
        $serviceValue = $this->session->userdata['serviceSession'];
        $data['serviceData'] = $serviceValue;
        echo json_encode($data);
    }
     /**
     * view invoice
     * @access public
     * @return void
     * @param int
     */
    public function view($sales_id=3) {
        $sales_id = $this->custom->encrypt_decrypt($sales_id, 'decrypt');
        $data = array();
        $data['info'] = $this->Sale_model->getSaleInfo($sales_id);
        $data['details'] = $this->Sale_model->getSaleDetails($sales_id);
        $this->load->view('sale/print', $data);
    }
     /**
     * view A4 size invoice
     * @access public
     * @return void
     * @param int
     */
    public function view_A4($sales_id) {
        $sales_id = $this->custom->encrypt_decrypt($sales_id, 'decrypt');
        $data = array();
        $data['info'] = $this->Sale_model->getSaleInfo($sales_id);
        $data['details'] = $this->Sale_model->getSaleDetails($sales_id);
        $this->load->view('sale/print_A4', $data);
    }
     /**
     * view invoice
     * @access public
     * @return void
     * @param int
     */
    public function view_invoice($sales_id) {
        $sales_id = $this->custom->encrypt_decrypt($sales_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $data = array();
        $data['info'] = $this->Sale_model->getSaleInfo($sales_id);
        $data['details'] = $this->Sale_model->getSaleDetails($sales_id);
        $print_format = $this->session->userdata('print_format');
        if($print_format=="80mm"){
            $this->load->view('sale/print_invoice', $data);
        }else{
            $this->load->view('sale/print_invoice_56mm', $data);
        }
    }
     /**
     * save Sales Items
     * @access public
     * @return void
     * @param string
     * @param int
     * @param string
     */
    public function saveSalesItems($item_menu_items, $ingredient_id, $table_name) {
        /*This all variables could not be escaped because this is an array field*/
        foreach ($item_menu_items as $row => $ingredient_id):
            $fmi = array();
            $fmi['ingredient_id'] = $ingredient_id;
            $fmi['consumption'] = $_POST['consumption'][$row];
            $fmi['ingredient_id'] = $ingredient_id;
            $fmi['user_id'] = $this->session->userdata('user_id');
            $fmi['outlet_id'] = $this->session->userdata('outlet_id');
            $this->Common_model->insertInformation($fmi, "tbl_sales_items");
        endforeach;
    }
     /**
     * item Menu Details
     * @access public
     * @return void
     * @param int
     */
    public function itemMenuDetails($id) {
        $encrypted_id = $id;
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['item_menu_details'] = $this->Common_model->getDataById($id, "tbl_sales");
        $data['main_content'] = $this->load->view('sale/itemMenuDetails', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * add New Customer By Ajax
     * @access public
     * @return object
     * @param no
     */
    public function addNewCustomerByAjax() {
        $data['name'] = $_GET['customer_name'];
        $data['phone'] = $_GET['mobile_no'];
        $data['email'] = $_GET['customerEmail'];
        $data['date_of_birth'] = $_GET['customerDateOfBirth'];
        $data['date_of_anniversary'] = $_GET['customerDateOfAnniversary'];
        $data['address'] = $_GET['customerAddress'];
        $data['user_id'] = $this->session->userdata('user_id');
        $data['company_id'] = $this->session->userdata('company_id');
        $this->db->insert('tbl_customers', $data);
        $customer_id = $this->db->insert_id();
        $data1 = array('customer_id' => $customer_id);
        echo json_encode($data1);
    }
     /**
     * getEncriptValue
     * @access public
     * @return object
     * @param no
     */
    public function getEncriptValue() {
        $id = $this->custom->encrypt_decrypt($_GET['sales_id'], 'encrypt');
        $data['encriptID'] = $id;
        echo json_encode($data);
    }
     /**
     * get Customer List
     * @access public
     * @return object
     * @param no
     */
    public function getCustomerList() {
        $company_id = $this->session->userdata('company_id');
        $data1 = $this->db->query("SELECT * FROM tbl_customers 
              WHERE company_id=$company_id")->result();
        //generate html content for view
        foreach ($data1 as $value) {
            if ($value->name == "Walk-in Customer") {
                echo '<option value="' . $value->id . '" >' . $value->name . '</option>';
            }
        }
        //generate html content for view
        foreach ($data1 as $value) {
            if ($value->name != "Walk-in Customer") {
                echo '<option value="' . $value->id . '" >' . $value->name . ' (' . $value->phone . ')' . '</option>';
            }
        }
        exit;
    }
     /**
     * add customer by ajax
     * @access public
     * @return int
     * @param no
     */
    public function add_customer_by_ajax(){
        $customer_id =htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
        $data['name'] = trim_checker(htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_name'))));
        $data['phone'] = trim_checker(htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_phone'))));
        $data['default_discount'] = trim_checker(htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_default_discount'))));
        $data['email'] = trim_checker($this->input->post($this->security->xss_clean('customer_email')));
        $data['password_online_user'] = md5(trim_checker($this->input->post($this->security->xss_clean('customer_password'))));
        if($this->input->post($this->security->xss_clean('customer_dob'))){
            $data['date_of_birth'] = date('Y-m-d',strtotime($this->input->post($this->security->xss_clean('customer_dob'))));
        }
        if($this->input->post($this->security->xss_clean('customer_doa'))){
            $data['date_of_anniversary'] = date('Y-m-d',strtotime($this->input->post($this->security->xss_clean('customer_doa'))));
        }
        $data['address'] = trim_checker(preg_replace('/\s+/', ' ',htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_delivery_address')))));
        $data['gst_number'] = trim_checker($this->input->post($this->security->xss_clean('customer_gst_number')));
        $data['same_or_diff_state'] = trim_checker($this->input->post($this->security->xss_clean('same_or_diff_state')));
        $is_new_address = trim_checker($this->input->post($this->security->xss_clean('is_new_address')));
        $data['user_id'] = $this->session->userdata('user_id');
        $data['company_id'] = $this->session->userdata('company_id');
       $id_return = 0;
        if($customer_id>0 && $customer_id!=""){
            $this->db->where('id', $customer_id);
            $this->db->update('tbl_customers', $data);
            $id_return =  $customer_id;
        }else{
            $this->db->insert('tbl_customers', $data);
            $id_return =  $this->db->insert_id();
        }
        $customer_delivery_address_modal_id = trim_checker($this->input->post($this->security->xss_clean('customer_delivery_address_modal_id')));
        if($is_new_address=="Yes"){
            $customer_address = array();
            $customer_address['customer_id'] = $id_return;
            $customer_address['address'] = $data['address'];
            $customer_address['is_active'] = 1;
            if($data['address']){
                $this->Common_model->insertInformation($customer_address, "tbl_customer_address");
            }
        }else if ($customer_delivery_address_modal_id){

            $data_old['is_active'] = '0';
            $this->db->where('customer_id', $id_return);
            $this->db->update('tbl_customer_address', $data_old);

            $customer_address = array();
            $customer_address['customer_id'] = $id_return;
            $customer_address['address'] = $data['address'];
            $customer_address['is_active'] = 1;
            if($data['address']){
                $this->Common_model->updateInformation($customer_address, $customer_delivery_address_modal_id, "tbl_customer_address");
            }
        }
        $is_online_order =  $this->session->userdata('is_online_order');

        $customer_return['customer_id'] = $id_return;
        $customer_return['online_customer_id'] = '';
        if($is_online_order=="Yes"){
            $customer_return['online_customer_id'] = $id_return;
            $this->session->set_userdata('online_customer_id',$id_return);
            $this->session->set_userdata('online_customer_name',$data['name']);
            $this->session->set_userdata('short_name', strtolower(substr($data['name'],0, 1)));
        }
        echo json_encode($customer_return) ;
    }
    public function online_customer_login_by_ajax(){
        $online_login_phone = trim_checker(htmlspecialcharscustom($this->input->post($this->security->xss_clean('online_login_phone'))));
        $online_login_password = trim_checker(htmlspecialcharscustom($this->input->post($this->security->xss_clean('online_login_password'))));

        $get_customer_details = get_customer_details($online_login_phone,$online_login_password);
        $customer_return['status'] = false;
        $customer_return['customer_id'] = '';
        $customer_return['online_customer_id'] = '';
        if($get_customer_details){
            $customer_return['status'] = true;
            $customer_return['customer_id'] = $get_customer_details->id;
            $customer_return['online_customer_id'] = $get_customer_details->id;
            $this->session->set_userdata('online_customer_id', $get_customer_details->id);
            $this->session->set_userdata('online_customer_name', $get_customer_details->name);
            $this->session->set_userdata('short_name', strtolower(substr($get_customer_details->name,0, 1)));
        }
        echo json_encode($customer_return) ;
    }
     /**
     * get all customers for this user
     * @access public
     * @return object
     * @param no
     */
    public function get_all_customers_for_this_user(){
        $company_id = $this->session->userdata('company_id');
        $data1 = $this->db->query("SELECT * FROM tbl_customers 
              WHERE company_id=$company_id AND del_status='Live'")->result();
        echo json_encode($data1);
    }
     /**
     * add sale by ajax
     * @access public
     * @return int
     * @param no
     */
    public function add_kitchen_sale_by_ajax(){
        //check creating invoice
        $status_creating_invocie = true;
        if(isServiceAccessOnly('sGmsJaFJE')){
            if(!checkCreatePermissionInvoice()){
                $status_creating_invocie = false;
            }
        }
        if($status_creating_invocie==false){
            $return_data['invoice_status'] = '1';
            $return_data['invoice_msg'] = lang('not_permission_invoice_create_error');
            echo json_encode($return_data);
        }else{
            /*This variable could not be escaped because this is json data*/
            $order = $this->input->post('order');
            $order_details = (json_decode($order));
            //this id will be 0 when there is new order, but will be greater then 0 when there is modification
            //on previous order
            $sale_no = $order_details->sale_no;
            $sale_d = getKitchenSaleDetailsBySaleNo($sale_no);
            $data = array();
            $data['customer_id'] = trim_checker($order_details->customer_id);
            $data['counter_id'] = trim_checker($order_details->counter_id);

            $is_self_order = $this->session->userdata('is_self_order');
            $is_online_order = $this->session->userdata('is_online_order');

            $self_order_table_person = htmlspecialcharscustom($order_details->self_order_table_person);
            $self_order_table_id = htmlspecialcharscustom($order_details->self_order_table_id);

            if($is_self_order=="Yes" && $is_online_order!="Yes"){
                $data['is_self_order'] = "Yes";
                $data['is_accept'] = 2;
                $data['self_order_ran_code'] = $this->session->userdata('self_order_ran_code');
                $data['online_self_order_receiving_id'] = getOnlineSelfOrderReceivingId($this->session->userdata('outlet_id'));
            }
          
            if($is_online_order=="Yes"){
                $data['is_online_order'] = "Yes";
                $data['is_accept'] = 2;
                $data['online_order_receiving_id'] = getOnlineOrderReceivingId($this->session->userdata('outlet_id'));
            }

            $designation = $this->session->userdata('designation');

            if($designation!="Admin" && $designation!="Super Admin"){
                $data['order_receiving_id'] = getOrderReceivingId($this->session->userdata('user_id'));
                $data['order_receiving_id_admin'] = getOrderReceivingIdAdmin();
            } 
            $data['self_order_content'] = $order;
            $data['del_address'] = trim_checker($order_details->customer_address)!="undefined"?trim_checker($order_details->customer_address):"";
            $data['delivery_partner_id'] = trim_checker($order_details->delivery_partner_id);
            $data['rounding_amount_hidden'] = trim_checker($order_details->rounding_amount_hidden);
            $data['previous_due_tmp'] = trim_checker($order_details->previous_due_tmp);
            $data['total_items'] = trim_checker($order_details->total_items_in_cart);
            $data['sub_total'] = trim_checker($order_details->sub_total);
            $data['charge_type'] = trim_checker($order_details->charge_type);
            $data['vat'] = trim_checker($order_details->total_vat);
            $data['total_payable'] = trim_checker($order_details->total_payable);
            $data['total_item_discount_amount'] = trim_checker($order_details->total_item_discount_amount);
            $data['sub_total_with_discount'] = trim_checker($order_details->sub_total_with_discount);
            $data['sub_total_discount_amount'] = trim_checker($order_details->sub_total_discount_amount);
            $data['total_discount_amount'] = trim_checker($order_details->total_discount_amount);
            $data['delivery_charge'] = trim_checker($order_details->delivery_charge);
            $data['delivery_charge_actual_charge'] = trim_checker($order_details->delivery_charge_actual_charge);
            $data['tips_amount'] = trim_checker($order_details->tips_amount);
            $data['tips_amount_actual_charge'] = trim_checker($order_details->tips_amount_actual_charge);
            $data['sub_total_discount_value'] = trim_checker($order_details->sub_total_discount_value);
            $data['sub_total_discount_type'] = trim_checker($order_details->sub_total_discount_type);
            $data['orders_table_text'] = trim_checker($order_details->orders_table_text);
            $data['waiter_id'] = trim_checker($order_details->waiter_id);
            $data['outlet_id'] = $this->session->userdata('outlet_id');
            $data['company_id'] = $this->session->userdata('company_id');
            $data['sale_date'] = trim_checker(isset($order_details->open_invoice_date_hidden) && $order_details->open_invoice_date_hidden?$order_details->open_invoice_date_hidden:date('Y-m-d'));
            $data['date_time'] = date('Y-m-d H:i:s',strtotime($order_details->date_time));
            $data['order_time'] = date("H:i:s",strtotime($order_details->order_time));
            $data['order_status'] = trim_checker($order_details->order_status);
            $data['table_id'] = trim_checker($order_details->table_id);
            $data['is_merge'] = isset($order_details->is_merge) && $order_details->is_merge?$order_details->is_merge:'';
            $data['zatca_value'] = trim_checker($order_details->zatca_invoice_value);
            $data['sale_no'] = $sale_no;
            $today_ = date('Y-m-d');
            if($today_<$data['sale_date']){
            //1 is runny sale, 2 is future sales, 3 is future status null
                $data['future_sale_status'] = 2;
            }

            $data['is_pickup_sale'] = 1;
            $total_tax = 0;
            if(isset($order_details->sale_vat_objects) && $order_details->sale_vat_objects){
                foreach ($order_details->sale_vat_objects as $keys=>$val){
                    $total_tax+=$val->tax_field_amount;
                }
            }
            $data['vat'] = $total_tax;
            $data['sale_vat_objects'] = json_encode($order_details->sale_vat_objects);
            $data['order_type'] = trim_checker($order_details->order_type);
            
            $this->db->trans_begin();
            $sale_id = isset($sale_d->id) && $sale_d->id?$sale_d->id:'';

            $status_of_old_item = array();
            if($sale_id>0){
                $data['user_id'] = $sale_d->user_id;
                $data['modified'] = 'Yes';
                $data['is_update_sender'] = 1;
                $data['is_update_receiver'] = 1;
                $data['is_update_receiver_admin'] = 1;
                $this->db->where('id', $sale_id);
                $this->db->update('tbl_kitchen_sales', $data);
                $status_of_old_item = checkAndRemoveAllRemovedItem($order_details->items,$sale_id);
               
            }else{
                $data['user_id'] = $this->session->userdata('user_id');
                $data['random_code'] = trim_checker(isset($order_details->random_code) && $order_details->random_code?$order_details->random_code:'');
                $this->db->insert('tbl_kitchen_sales', $data);
                $sale_id = $this->db->insert_id();

                if($is_self_order=="Yes" && $is_online_order!="Yes"){
                    $notification = "a new self order has been placed, Order Number is: ".$sale_no;
                    $notification_data = array();
                    $notification_data['notification'] = $notification;
                    $notification_data['sale_id'] = $sale_id;
                    $notification_data['waiter_id'] = trim_checker($order_details->waiter_id);
                    $notification_data['outlet_id'] = $this->session->userdata('outlet_id');
                    $this->db->insert('tbl_notifications', $notification_data);
                }
                if($is_online_order=="Yes"){
                    $notification = "a new online order has been placed, Order Number is: ".$sale_no;
                    $notification_data = array();
                    $notification_data['notification'] = $notification;
                    $notification_data['sale_id'] = $sale_id;
                    $notification_data['waiter_id'] = trim_checker($order_details->waiter_id);
                    $notification_data['outlet_id'] = $this->session->userdata('outlet_id');
                    $this->db->insert('tbl_notifications', $notification_data);
                }
            }
            if($is_self_order=="Yes" || $is_online_order=="Yes"){
                $order_table_info = array();
                $order_table_info['persons'] = $self_order_table_person;
                $order_table_info['booking_time'] = date('Y-m-d H:i:s');
                $order_table_info['sale_id'] = $sale_id;
                $order_table_info['sale_no'] = $sale_no;
                $order_table_info['outlet_id'] = $this->session->userdata('outlet_id');
                $order_table_info['table_id'] = $self_order_table_id;
                $this->db->insert('tbl_orders_table',$order_table_info);

                $data_update_text['orders_table_text'] = getTableName($self_order_table_id);
                $this->db->where('id', $sale_id);
                $this->db->update('tbl_kitchen_sales', $data_update_text);
            }else{
                foreach($order_details->orders_table as $single_order_table){
                    $order_table_info = array();
                    $order_table_info['persons'] = $single_order_table->persons;
                    $order_table_info['booking_time'] = date('Y-m-d H:i:s');
                    $order_table_info['sale_id'] = $sale_id;
                    $order_table_info['sale_no'] = $sale_no;
                    $order_table_info['outlet_id'] = $this->session->userdata('outlet_id');
                    $order_table_info['table_id'] = $single_order_table->table_id;
                    $this->db->insert('tbl_orders_table',$order_table_info);
                }
            }
            if($sale_id>0 && count($order_details->items)>0){
                $previous_food_id = 0;
                $arr_item_id = array();
                foreach($order_details->items as $key_counter=>$item){
                    $tmp_var_111 = isset($item->p_qty) && $item->p_qty && $item->p_qty!='undefined'?$item->p_qty:0;
                    $tmp = $item->qty-$tmp_var_111;
                    $tmp_var = 0;
                    if($tmp>0){
                        $tmp_var = $tmp;
                    }

                    $item_data = array();
                    $item_data['food_menu_id'] = $item->food_menu_id;
                    $item_data['menu_name'] = $item->menu_name;
                    if($item->is_free==1){
                        $item_data['is_free_item'] = $previous_food_id;
                    }else{
                        $item_data['is_free_item'] = 0;
                    }

                    $item_data['qty'] = $item->qty;
                    $item_data['tmp_qty'] = $tmp_var;
                    $item_data['menu_price_without_discount'] = $item->menu_price_without_discount;
                    $item_data['menu_price_with_discount'] = $item->menu_price_with_discount;
                    $item_data['menu_unit_price'] = $item->menu_unit_price;
                    $item_data['menu_taxes'] = json_encode($item->item_vat);
                    $item_data['menu_discount_value'] = $item->menu_discount_value;
                    $item_data['discount_type'] = $item->discount_type;
                    $item_data['menu_note'] = $item->item_note;
                    $item_data['menu_combo_items'] = $item->menu_combo_items;
                    $item_data['discount_amount'] = $item->item_discount_amount;
                    $item_data['discount_reason'] = $item->discount_reason;
                    $item_data['item_type'] = "Kitchen Item";
                    $item_data['cooking_start_time'] = ($item->item_cooking_start_time=="" || $item->item_cooking_start_time=="0000-00-00 00:00:00")?'0000-00-00 00:00:00':date('Y-m-d H:i:s',strtotime($item->item_cooking_start_time));
                    $item_data['cooking_done_time'] = ($item->item_cooking_done_time=="" || $item->item_cooking_done_time=="0000-00-00 00:00:00")?'0000-00-00 00:00:00':date('Y-m-d H:i:s',strtotime($item->item_cooking_done_time));
                    $item_data['previous_id'] = ($item->item_previous_id=="")?0:$item->item_previous_id;
                    $item_data['sales_id'] = $sale_id;
                    $item_data['user_id'] = $this->session->userdata('user_id');
                    $item_data['outlet_id'] = $this->session->userdata('outlet_id');
                    if($order_details->customer_id!=1){
                        $item_data['loyalty_point_earn'] = ($item->qty * getLoyaltyPointByFoodMenu($item->food_menu_id,''));
                    }
                    $item_data['del_status'] = 'Live';
 
                    if(isset($status_of_old_item[$item->food_menu_id."__".$sale_id]) && $status_of_old_item[$item->food_menu_id."__".$sale_id]!=""){
                        $item_data['cooking_status'] = $status_of_old_item[$item->food_menu_id."__".$sale_id];
                    }else{
                        $item_data['cooking_status'] = 'New';
                    }

                    $sales_details_id = '';
                    if($sale_id){
                        $preview_id_counter_value = isset($arr_item_id[$item->food_menu_id]) && $arr_item_id[$item->food_menu_id]?$arr_item_id[$item->food_menu_id]:0;
                        $arr_item_id[$item->food_menu_id] = $preview_id_counter_value + 1;
                        $check_exist_item = checkExistItem($sale_id,$item->food_menu_id,$preview_id_counter_value);
                        if(isset($check_exist_item) && $check_exist_item){
                            $sales_details_id = $check_exist_item->id;
                            if($item->qty!=$check_exist_item->qty){
                                $item_data['is_print'] = 1;
                                $updated_notifications = $this->Common_model->getOrderedKitchens($sale_id);
                                foreach ($updated_notifications as $k=>$kitchen){
                                    $notification_message = 'Order:'.$sale_no.' has been modified. Modified item: '.$item->menu_name.", Modified item qty:".$item->qty;
                                    $bar_kitchen_notification_data = array();
                                    $bar_kitchen_notification_data['notification'] = $notification_message;
                                    $bar_kitchen_notification_data['sale_id'] = $sale_id;
                                    $bar_kitchen_notification_data['outlet_id'] = $this->session->userdata('outlet_id');
                                    $bar_kitchen_notification_data['kitchen_id'] = $kitchen->kitchen_id;
                                    $this->db->insert('tbl_notification_bar_kitchen_panel', $bar_kitchen_notification_data);
                                }
                            }
                            $this->Common_model->updateInformation($item_data, $sales_details_id, "tbl_kitchen_sales_details");
                        }else{
                            $this->db->insert('tbl_kitchen_sales_details', $item_data);
                            $sales_details_id = $this->db->insert_id();
                        }
                    }else{
                        $this->db->insert('tbl_kitchen_sales_details', $item_data);
                        $sales_details_id = $this->db->insert_id();
                    }

                    $previous_food_id = $sales_details_id;
                    $update_previous_id = array();
                    $update_previous_id['previous_id'] = $previous_food_id;
                    $this->Common_model->updateInformation($update_previous_id, $sales_details_id, "tbl_kitchen_sales_details");


                    $modifier_id_array = ($item->modifiers_id!="")?explode(",",$item->modifiers_id):null;
                    $modifier_price_array = ($item->modifiers_price!="")?explode(",",$item->modifiers_price):null;
                    $modifier_vat_array = (isset($item->modifier_vat) && $item->modifier_vat!="")?explode("|||",$item->modifier_vat):null;
                    if(!empty($modifier_id_array)>0){
                        $i = 0;
                        foreach($modifier_id_array as $key1=>$single_modifier_id){
                            $modifier_data = array();
                            $modifier_data['modifier_id'] =$single_modifier_id;
                            $modifier_data['modifier_price'] = $modifier_price_array[$i];
                            $modifier_data['food_menu_id'] = $item->food_menu_id;
                            $modifier_data['sales_id'] = $sale_id;
                            $modifier_data['sales_details_id'] = $sales_details_id;
                            $modifier_data['menu_taxes'] = isset($modifier_vat_array[$key1]) && $modifier_vat_array[$key1]?$modifier_vat_array[$key1]:'';
                            $modifier_data['user_id'] = $this->session->userdata('user_id');
                            $modifier_data['outlet_id'] = $this->session->userdata('outlet_id');
                            $modifier_data['customer_id'] =$order_details->customer_id;
                            if($sale_id){
                                $check_exist_modifer = checkExistItemModifer($sale_id,$item->food_menu_id,$sales_details_id,$single_modifier_id);
                                if(isset($check_exist_modifer) && $check_exist_modifer){
                                    $sales_details_modifier_id = $check_exist_modifer->id;
                                    if($item->qty!=$check_exist_item->qty){
                                        $modifier_data['is_print'] = 1;
                                    }
                                    $this->Common_model->updateInformation($modifier_data, $sales_details_modifier_id, "tbl_kitchen_sales_details_modifiers");

                                }else{
                                    $this->db->insert('tbl_kitchen_sales_details_modifiers', $modifier_data);
                                }
                            }else{
                                $this->db->insert('tbl_kitchen_sales_details_modifiers', $modifier_data);
                            }

                            $i++;
                        }
                    }
                }
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                $printers_popup_print = $this->Common_model->getOrderedPrinter($sale_id,1);
                $printers_direct_print = $this->Common_model->getOrderedPrinter($sale_id,2);
                $is_printing_return = 1;
                foreach ($printers_popup_print as $ky=>$value){
                    if(isset($value->id) && $value->id){
                        $is_printing_return++;
                        $sale_items = $this->Common_model->getAllKitchenItemsAuto($sale_id,$value->id,1);
                        foreach($sale_items as $single_item_by_sale_id){
                            $modifier_information = $this->Sale_model->getModifiersBySaleAndSaleDetailsIdKitchenAuto($sale_id,$single_item_by_sale_id->sales_details_id);
                            $single_item_by_sale_id->modifiers = $modifier_information;

                            $modifiers_id = '';
                            $modifiers_name = '';
                            $modifiers_price = '';
                            foreach($modifier_information as $ky1=>$val){
                                $modifiers_id.=$val->modifier_id;
                                $modifiers_name.=$val->name;
                                $modifiers_price.=$val->modifier_price;

                                if($ky1<(sizeof($modifier_information))-1){
                                    $modifiers_id.=",";
                                    $modifiers_name.=",";
                                    $modifiers_price.=",";
                                }
                            }
                            $single_item_by_sale_id->modifiers_id = $modifiers_id;
                            $single_item_by_sale_id->modifiers_name = $modifiers_name;
                            $single_item_by_sale_id->modifiers_price = $modifiers_price;
                            
                        }
                        if($sale_items){
                            $printers_popup_print[$ky]->ipvfour_address = "Yes";
                            $order_type = '';
                            if($order_details->order_type==1){
                                $order_type = lang('dine');
                            }else if($order_details->order_type==2){
                                $order_type = lang('take_away');
                            }else if($order_details->order_type==3){
                                $order_type = lang('delivery');
                            }
                            $printers_popup_print[$ky]->store_name = lang('KOT').":".($value->kitchen_name);
                            $printers_popup_print[$ky]->sale_type = $order_type;
                            $printers_popup_print[$ky]->sale_no_p = $sale_no;
                            $printers_popup_print[$ky]->date = escape_output(date($this->session->userdata('date_format'), strtotime($data['sale_date'])));
                            $printers_popup_print[$ky]->time_inv = $data['order_time'];
                            $printers_popup_print[$ky]->sales_associate = $order_details->user_name;
                            $printers_popup_print[$ky]->customer_name = $order_details->customer_name;
                            $printers_popup_print[$ky]->customer_address = getCustomerAddress($order_details->customer_id);
                            $printers_popup_print[$ky]->waiter_name = $order_details->waiter_name;
                            $printers_popup_print[$ky]->customer_table = $order_details->orders_table_text;
                            $printers_popup_print[$ky]->lang_order_type = lang('order_type');
                            $printers_popup_print[$ky]->lang_Invoice_No = lang('Invoice_No');
                            $printers_popup_print[$ky]->lang_date = lang('date');
                            $printers_popup_print[$ky]->lang_Sales_Associate = lang('Sales_Associate');
                            $printers_popup_print[$ky]->lang_customer = lang('customer');
                            $printers_popup_print[$ky]->lang_address = lang('address');
                            $printers_popup_print[$ky]->lang_gst_number = lang('gst_number');
                            $printers_popup_print[$ky]->lang_waiter = lang('waiter');
                            $printers_popup_print[$ky]->lang_table = lang('table');
                            $printers_popup_print[$ky]->items = $sale_items;
                        }else{
                            $printers_popup_print[$ky]->ipvfour_address = "";
                        }
                    }
                }

                foreach ($printers_direct_print as $ky=>$value){
                    if(isset($value->id) && $value->id){
                        $is_printing_return++;
                        $sale_items = $this->Common_model->getAllKitchenItemsAuto($sale_id,$value->id,1);
                        foreach($sale_items as $single_item_by_sale_id){
                            $modifier_information = $this->Sale_model->getModifiersBySaleAndSaleDetailsIdKitchenAuto($sale_id,$single_item_by_sale_id->sales_details_id);
                            $single_item_by_sale_id->modifiers = $modifier_information;
                                $modifiers_id = '';
                                $modifiers_name = '';
                                $modifiers_price = '';
                                foreach($modifier_information as $ky1=>$val){
                                    $modifiers_id.=$val->modifier_id;
                                    $modifiers_name.=$val->name;
                                    $modifiers_price.=$val->modifier_price;

                                    if($ky1<(sizeof($modifier_information))-1){
                                        $modifiers_id.=",";
                                        $modifiers_name.=",";
                                        $modifiers_price.=",";
                                    }
                                }
                                $single_item_by_sale_id->modifiers_id = $modifiers_id;
                                $single_item_by_sale_id->modifiers_name = $modifiers_name;
                                $single_item_by_sale_id->modifiers_price = $modifiers_price;
                                
                        }
                        if($sale_items){
                            $printers_direct_print[$ky]->ipvfour_address = getIPv4WithFormat($value->ipvfour_address);
                            $order_type = '';
                            if($order_details->order_type==1){
                                $order_type = lang('dine');
                            }else if($order_details->order_type==2){
                                $order_type = lang('take_away');
                            }else if($order_details->order_type==3){
                                $order_type = lang('delivery');
                            }
                            $printers_direct_print[$ky]->store_name = lang('KOT').":".($value->kitchen_name);
                            $printers_direct_print[$ky]->sale_type = $order_type;
                            $printers_direct_print[$ky]->sale_no_p = $sale_no;
                            $printers_direct_print[$ky]->date = escape_output(date($this->session->userdata('date_format'), strtotime($data['sale_date'])));
                            $printers_direct_print[$ky]->time_inv = $data['order_time'];
                            $printers_direct_print[$ky]->sales_associate = $order_details->user_name;
                            $printers_direct_print[$ky]->customer_name = $order_details->customer_name;
                            $printers_direct_print[$ky]->customer_address = getCustomerAddress($order_details->customer_id);
                            $printers_direct_print[$ky]->waiter_name = $order_details->waiter_name;
                            $printers_direct_print[$ky]->customer_table = $order_details->orders_table_text;
                            $printers_direct_print[$ky]->lang_order_type = lang('order_type');
                            $printers_direct_print[$ky]->lang_Invoice_No = lang('Invoice_No');
                            $printers_direct_print[$ky]->lang_date = lang('date');
                            $printers_direct_print[$ky]->lang_Sales_Associate = lang('Sales_Associate');
                            $printers_direct_print[$ky]->lang_customer = lang('customer');
                            $printers_direct_print[$ky]->lang_address = lang('address');
                            $printers_direct_print[$ky]->lang_gst_number = lang('gst_number');
                            $printers_direct_print[$ky]->lang_waiter = lang('waiter');
                            $printers_direct_print[$ky]->lang_table = lang('table');
                            $items = "\n";
                            $count = 1;
                            foreach ($sale_items as $item){
                                if($item->tmp_qty):
                                    $items.= printLine(("#".$count." ".(getPlanData($item->menu_name))).": " .($item->tmp_qty), $value->characters_per_line)."\n";
                                    if($item->menu_combo_items && $item->menu_combo_items!=null){
                                        $items.= (printText(lang('combo_txt').': '.$item->menu_combo_items,$value->characters_per_line)."\n");
                                    }
                                    if($item->menu_note){
                                        $items.= (printText(lang('note').': '.$item->menu_note,$value->characters_per_line)."\n");
                                    }
                                    if(count($item->modifiers)>0){
                                        foreach($item->modifiers as $modifier){
                                            $items.= "   ".printLine((getPlanData($modifier->name)).": " .($item->tmp_qty), ($value->characters_per_line - 3))."\n";
                                        }
                                    }
                                    $count++;
                                endif;
                            }
                            $printers_direct_print[$ky]->items = $items;
                             
                            if($items=="\n"){ 
                                unset($printers_direct_print[$ky]);
                            }
                        }else{
                            $printers_direct_print[$ky]->ipvfour_address = '';
                        }
                    }
                }

                    $company_id = $this->session->userdata('company_id');
                    $company = $this->Common_model->getDataById($company_id, "tbl_companies");
                    $web_type = $company->printing_kot;

                    $return_status = true;
                    $kitchens = $this->Common_model->checkPrinterForKOT($sale_id);
                    $status_message = '';
                    if($kitchens){
                        foreach ($kitchens as $kitchen){
                            if($kitchen->id){
                            }else{
                                $base_url = base_url()."Kitchen/panel/".$kitchen->kitchen_id;
                                $status_message.="<a target='_blank' style='text-decoration: none' href='$base_url'>KOT print failed of ".$kitchen->kitchen_name." because the printer is not connected. You may go to the kitchen panel or click here to got to kitchen panel</a>";
                                $status_message.="|||";
                                $return_status = false;
                            }
                        }
                    }
                    if($web_type=="web_browser_popup"){

                    }else{
                        if($this->session->has_userdata('is_online_order')!="Yes" && !isFoodCourt()){
                            $return_data['printer_server_url'] = getIPv4WithFormat($company->print_server_url_kot);
                            $return_data['content_data_popup_print'] = $printers_popup_print;
                            $return_data['content_data_direct_print'] = $printers_direct_print;
                            $return_data['print_type'] = "KOT";
                            $return_data['status'] = $return_status;
                            $return_data['sale_id'] = $sale_id;
                            $return_data['status_message'] = $status_message;
                            $return_data['invoice_status'] = '';
                            $return_data['invoice_msg'] = '';
                            echo json_encode($return_data);
                        }
                    }
                    }
                    }
        

    }
    public function pull_running_order(){
        /*This variable could not be escaped because this is json data*/
        $order = $this->input->post('order');
        $user_id = $this->input->post('user_id');
        $order_details = (json_decode($order));
        $sale_no = $order_details->sale_no;
        $sale_d = getExistOrderInfo($sale_no);

        $order_info = array();
        $order_info['sale_no'] = $sale_no;
        $order_info['order_content'] = $order;
        $order_info['user_id'] = $user_id;

        if(isset($sale_d) && $sale_d){
            $this->db->where('id', $sale_d->id);
            $this->db->update("tbl_running_orders", $order_info);
        }else{
            $this->db->insert('tbl_running_orders',$order_info);
        }
        echo json_encode("success");
    }
    public function resetTableData(){
        /*This variable could not be escaped because this is json data*/
        $outlet_id = $this->session->userdata('outlet_id');
    
        $this->db->delete("tbl_kitchen_sales_details", array("outlet_id" => $outlet_id));
        $this->db->delete("tbl_kitchen_sales_details_modifiers", array("outlet_id" => $outlet_id));
        $this->db->delete("tbl_kitchen_sales", array("outlet_id" => $outlet_id));
        
        echo json_encode("success");
    }
    public function put_table_content(){
        /*This variable could not be escaped because this is json data*/
        $table_info = $this->input->post('table_info');
        $table_id = $this->input->post('table_id');
        $order_details = (json_decode($table_info));
        $sale_no = $order_details->sale_no;
        $persons = $order_details->persons;

        $sale_d = getExistOrderInfoTable($sale_no,$table_id);

        $order_info = array();
        $order_info['sale_no'] = $sale_no;
        $order_info['table_id'] = $table_id;
        $order_info['persons'] = $persons;
        $order_info['table_content'] = $table_info;
        $order_info['outlet_id'] = $this->session->userdata('outlet_id');

        if(isset($sale_d) && $sale_d){
            $order_info['persons'] = ($sale_d->persons + $persons);
            $this->db->where('id', $sale_d->id);
            $this->db->update("tbl_running_order_tables", $order_info);
        }else{
            $this->db->insert('tbl_running_order_tables',$order_info);
        }
        echo json_encode("success");
    }
    public function pull_running_order_server(){
        /*This variable could not be escaped because this is json data*/
        $user_id = $this->session->userdata('user_id');
        $data = getRunningOrders($user_id);
        echo json_encode($data);
    }

   
    public function add_cancel_audit_report(){
        /*This variable could not be escaped because this is json data*/
        $order = $this->input->post('order');
        $reason = $this->input->post('reason');
        $order_details = (json_decode($order));

        $select_kitchen_row = getKitchenSaleDetailsBySaleNo($order_details->sale_no);
        if($select_kitchen_row){
            $this->db->delete("tbl_kitchen_sales_details", array("sales_id" => $select_kitchen_row->id));
            $this->db->delete("tbl_kitchen_sales_details_modifiers", array("sales_id" => $select_kitchen_row->id));
            $this->db->delete("tbl_kitchen_sales", array("id" => $select_kitchen_row->id));
        }

        $txt = '<b>Reason: '.$reason."</b>";
        $txt .= '<br>';

        $customer_info = getCustomerData($order_details->customer_id);
        $txt.="Sale No: ".$order_details->sale_no.", ";
        $txt.="Sale Date: ".date($this->session->userdata('date_format'), strtotime($order_details->date_time)).", ";
        $txt.="Customer: ".(isset($customer_info) && $customer_info->name?$customer_info->name:'---')." - ".(isset($customer_info) && $customer_info->phone?$customer_info->phone:'').", ";

        if(isset($order_details->total_vat) && $order_details->total_vat){
            $txt.="VAT: ".$order_details->total_vat.",";
        }
        if(isset($order_details->total_discount_amount) && $order_details->total_discount_amount){
            $txt.="Discount: ".$order_details->total_discount_amount.", ";
        }
        if(isset($order_details->delivery_charge) && $order_details->delivery_charge){
            $txt.="Charge: ".$order_details->delivery_charge.", ";
        }
        if(isset($order_details->tips_amount) && $order_details->tips_amount){
            $txt.="Tips: ".$order_details->tips_amount.", ";
        }
        $txt.="Total Payable: ".$order_details->total_payable;
        if(count($order_details->items)>0){
            $txt.="<br><b>Items:</b><br>";
            foreach($order_details->items as $key=>$item){

                $txt.=$item->menu_name."("."$item->qty X $item->menu_unit_price".")";
                if($item->menu_combo_items  && $item->menu_combo_items!='undefined'){
                    $txt.="=><b>Combo Items: </b>";
                    $txt.=$item->menu_combo_items;
                }
                if($key < (sizeof($order_details->items) -1)){
                    $txt.=", ";
                }
                $modifier_id_array = ($item->modifiers_id!="")?explode(",",$item->modifiers_id):null;
                if(!empty($modifier_id_array)>0){
                    $i = 0;
                    $txt.=", <b>&nbsp;&nbsp;Modifier:</b>";
                    foreach($modifier_id_array as $key1=>$single_modifier_id){
                        $txt.="&nbsp;&nbsp;".getModifierNameById($single_modifier_id);
                        if($key1 < (sizeof($modifier_id_array) -1)){
                            $txt.=", ";
                        }
                        $i++;
                    }
                }
            }
        }

        $notification = "an order has been deleted, Order Number is: ".$order_details->sale_no;
        $notification_data = array();
        $notification_data['notification'] = $notification;
        $notification_data['sale_id'] = $select_kitchen_row->id;
        $notification_data['waiter_id'] = trim_checker($order_details->waiter_id);
        $notification_data['outlet_id'] = $this->session->userdata('outlet_id');
        $this->db->insert('tbl_notifications', $notification_data);

        //store audit log data
        putAuditLog($this->session->userdata('user_id'),$txt,"Cancelled Sale",date('Y-m-d H:i:s'));

    }
    public function add_sale_by_ajax_split(){
        $order_details = json_decode(json_decode($this->input->post('order')));
        //this id will be 0 when there is new order, but will be greater then 0 when there is modification
        //on previous order
        $sale_id_old_sale_id = $this->input->post('sale_id_old_sale_id');
        $is_last_split = trim_checker($order_details->is_last_split);
        $split_sale = $this->Common_model->getDataById($sale_id_old_sale_id, "tbl_sales");

        $data = array();
        $data['split_sale_id'] = $sale_id_old_sale_id;
        $data['customer_id'] = trim_checker($order_details->customer_id);
        $data['counter_id'] = trim_checker($order_details->counter_id);
        $data['delivery_partner_id'] = trim_checker($order_details->delivery_partner_id);
        $data['rounding_amount_hidden'] = trim_checker($order_details->rounding_amount_hidden);
        $data['previous_due_tmp'] = trim_checker($order_details->previous_due_tmp);
        $data['total_items'] = trim_checker($order_details->total_items_in_cart);
        $data['sub_total'] = trim_checker($order_details->sub_total);
        $data['charge_type'] = trim_checker($split_sale->charge_type);
        $data['vat'] = trim_checker($order_details->total_vat);
        $data['total_payable'] = trim_checker($order_details->total_payable);

        $data['total_item_discount_amount'] = trim_checker($order_details->total_item_discount_amount);
        $data['sub_total_with_discount'] = trim_checker($order_details->sub_total_with_discount);
        $data['sub_total_discount_amount'] = trim_checker($order_details->sub_total_discount_amount);
        $data['total_discount_amount'] = trim_checker($order_details->total_discount_amount);
        $data['delivery_charge'] = trim_checker($order_details->delivery_charge);
        $data['delivery_charge_actual_charge'] = trim_checker($order_details->delivery_charge_actual_charge);
        $data['tips_amount'] = trim_checker($order_details->tips_amount);
        $data['tips_amount_actual_charge'] = trim_checker($order_details->tips_amount_actual_charge);
        $data['sub_total_discount_value'] = trim_checker($order_details->sub_total_discount_value);
        $data['sub_total_discount_type'] = trim_checker($order_details->sub_total_discount_type);

        $data['user_id'] = $this->session->userdata('user_id');
        $data['waiter_id'] = trim_checker($split_sale->waiter_id);
        $data['outlet_id'] = $this->session->userdata('outlet_id');
        $data['company_id'] = $this->session->userdata('company_id');
        $data['sale_date'] = trim_checker(isset($order_details->open_invoice_date_hidden) && $order_details->open_invoice_date_hidden?$order_details->open_invoice_date_hidden:date('Y-m-d'));
        $data['date_time'] = date('Y-m-d H:i:s',strtotime($split_sale->date_time));
        $data['order_time'] = date('Y-m-d H:i:s',strtotime($split_sale->date_time));
        $data['order_status'] = trim_checker($order_details->order_status);

        $total_tax = 0;
        if(isset($order_details->sale_vat_objects) && $order_details->sale_vat_objects){
            foreach ($order_details->sale_vat_objects as $keys=>$val){
                $total_tax+=$val->tax_field_amount;
            }
        }
        $data['vat'] = $total_tax;
        $data['sale_vat_objects'] = json_encode($order_details->sale_vat_objects);

        $data['order_type'] = trim_checker($split_sale->order_type);
        $this->db->trans_begin();
        $data['random_code'] = getRandomCode(15);
        $query = $this->db->insert('tbl_sales', $data);
        $sales_id = $this->db->insert_id();

        $split_total_bill = getSplitTotalBill($sale_id_old_sale_id);
        $sale_no = str_pad($split_total_bill, 3, '0', STR_PAD_LEFT);

        $sale_no_update_array = array();
        $sale_no_update_array['sale_no'] = $split_sale->sale_no."-".$sale_no;
        $this->db->where('id', $sales_id);
        $this->db->update('tbl_sales', $sale_no_update_array);

            $old_update_array = array();
            $old_update_array['sub_total'] = $split_sale->sub_total - trim_checker($order_details->sub_total);
            $old_update_array['vat'] = (float)$split_sale->vat - trim_checker($order_details->total_vat);
            $old_update_array['total_payable'] = $split_sale->total_payable - trim_checker($order_details->total_payable);
            $old_update_array['total_item_discount_amount'] = (float)$split_sale->total_item_discount_amount - trim_checker($order_details->total_item_discount_amount);
            $old_update_array['sub_total_with_discount'] = (float)$split_sale->sub_total_with_discount - (trim_checker(($order_details->sub_total)- trim_checker($order_details->sub_total_discount_amount)));
            $old_update_array['sub_total_discount_amount'] = $split_sale->sub_total_discount_amount - trim_checker($order_details->sub_total_discount_amount);
            $old_update_array['total_discount_amount'] = (float)$split_sale->total_discount_amount - trim_checker($order_details->total_discount_amount);
            $old_update_array['delivery_charge'] = (float)$split_sale->delivery_charge_actual_charge - trim_checker($order_details->delivery_charge_actual_charge);
            $old_update_array['delivery_charge_actual_charge'] = (float)$split_sale->delivery_charge_actual_charge - trim_checker($order_details->delivery_charge_actual_charge);
            $old_update_array['tips_amount'] = (float)$split_sale->tips_amount_actual_charge - trim_checker($order_details->tips_amount_actual_charge);
            $old_update_array['tips_amount_actual_charge'] = (float)$split_sale->tips_amount_actual_charge - trim_checker($order_details->tips_amount_actual_charge);
            $old_update_array['sub_total_discount_value'] = (float)$split_sale->sub_total_discount_value - trim_checker($order_details->sub_total_discount_value);
            $old_update_array['sub_total_discount_type'] = "fixed";
            $this->db->where('id', $sale_id_old_sale_id);
            $this->db->update('tbl_sales', $old_update_array);

        //update table
        $exist_tables = $this->Common_model->getAllByCustomId($sale_id_old_sale_id,'sale_id',"tbl_orders_table",'');
        $order_table_info = array();
        $is_update = 1;
        $table_update_id = 0;
        foreach ($exist_tables as $vl_tbl){
            if($is_update==1){
                $is_update++;
                $order_table_info['persons'] = $vl_tbl->persons - 1;
                if($vl_tbl->persons==1){
                    $this->db->delete('tbl_orders_table', array('id' => $vl_tbl->id));
                }else{
                    $table_update_id = $vl_tbl->id;
                }
            }
        }

        if($table_update_id){
            $this->Common_model->updateInformation($order_table_info, $table_update_id, "tbl_orders_table");
        }


        $data_sale_consumptions = array();
        $data_sale_consumptions['sale_id'] = $sales_id;
        $data_sale_consumptions['user_id'] = $this->session->userdata('user_id');
        $data_sale_consumptions['outlet_id'] = $this->session->userdata('outlet_id');
        $data_sale_consumptions['del_status'] = 'Live';
        $this->db->insert('tbl_sale_consumptions',$data_sale_consumptions);
        $sale_consumption_id = $this->db->insert_id();

        if($sales_id>0 && count($order_details->items)>0){
            $previous_food_id = 0;
            foreach($order_details->items as $item){
                $exist_food_menu = getExistFoodMenu($sale_id_old_sale_id,$item->item_id);
                 if(isset($exist_food_menu) && $exist_food_menu->qty){
                     $tamp_split_qty_remaining = $exist_food_menu->qty - $item->item_quantity;
                     $tamp_split_discount_remaining = $exist_food_menu->discount_amount - $item->item_discount;
                     $tamp_split_item_price_without_discount_remaining = $exist_food_menu->menu_price_without_discount - $item->menu_price_without_discount;
                     $tamp_split_item_price_with_discount_remaining = $exist_food_menu->menu_price_with_discount - $item->item_price_with_discount;

                     $update_arr = array();
                         $update_arr['qty'] = $tamp_split_qty_remaining;
                         $update_arr['tmp_qty'] = $tamp_split_qty_remaining;
                         $update_arr['menu_price_without_discount'] =$tamp_split_item_price_without_discount_remaining;
                         $update_arr['menu_price_with_discount'] =$tamp_split_item_price_with_discount_remaining;
                         $update_arr['menu_discount_value'] =$tamp_split_discount_remaining;
                         $update_arr['discount_amount'] =$tamp_split_discount_remaining;
                         $this->Common_model->updateInformation($update_arr, $exist_food_menu->id, "tbl_sales_details");


                     $item_data = array();
                     $item_data['food_menu_id'] = $item->item_id;
                     $item_data['menu_name'] = $exist_food_menu->menu_name;
                     if($item->is_free==1){
                         $item_data['is_free_item'] = $previous_food_id;
                     }else{
                         $item_data['is_free_item'] = 0;
                     }

                     $item_data['qty'] = $item->item_quantity;
                     $item_data['tmp_qty'] = $item->item_quantity;
                     $item_data['menu_price_without_discount'] = $item->menu_price_without_discount;
                     $item_data['menu_price_with_discount'] = $item->item_price_with_discount;
                     $item_data['menu_unit_price'] = $item->item_unit_price;
                     $item_data['menu_taxes'] = '';
                     $item_data['menu_discount_value'] = $item->item_discount;
                     $item_data['discount_type'] = $item->discount_type;
                     $item_data['menu_note'] = $exist_food_menu->menu_note;;
                     $item_data['menu_combo_items'] = $exist_food_menu->menu_combo_items;;
                     $item_data['is_free_item'] = $exist_food_menu->is_free_item;;
                     $item_data['discount_amount'] = $item->item_discount_amount;
                     $item_data['item_type'] = "Kitchen Item";
                     $item_data['cooking_status'] = ($item->item_cooking_status=="")?NULL:$item->item_cooking_status;
                     $item_data['cooking_start_time'] = ($item->item_cooking_start_time=="" || $item->item_cooking_start_time=="0000-00-00 00:00:00")?'0000-00-00 00:00:00':date('Y-m-d H:i:s',strtotime($item->item_cooking_start_time));
                     $item_data['cooking_done_time'] = ($item->item_cooking_done_time=="" || $item->item_cooking_done_time=="0000-00-00 00:00:00")?'0000-00-00 00:00:00':date('Y-m-d H:i:s',strtotime($item->item_cooking_done_time));
                     $item_data['previous_id'] = ($item->item_previous_id=="")?0:$item->item_previous_id;
                     $item_data['sales_id'] = $sales_id;
                     $item_data['user_id'] = $this->session->userdata('user_id');
                     $item_data['outlet_id'] = $this->session->userdata('outlet_id');
                     if($order_details->customer_id!=1){
                         $item_data['loyalty_point_earn'] = ($item->item_quantity * getLoyaltyPointByFoodMenu($item->item_id,''));
                     }
                     $item_data['del_status'] = 'Live';
                     $item_data['cooking_status'] = 'New';
                     $this->db->insert('tbl_sales_details', $item_data);
                     $sales_details_id = $this->db->insert_id();
                     $previous_food_id = $sales_details_id;
                     if($item->item_previous_id==""){
                         $previous_id_update_array = array('previous_id' => $sales_details_id);
                         $this->db->where('id', $sales_details_id);
                         $this->db->update('tbl_sales_details', $previous_id_update_array);
                     }

                     $item_details = $this->db->query("SELECT * FROM tbl_food_menus WHERE id=$item->item_id")->row();

                     if(isset($item_details->product_type) && $item_details->product_type==1){
                         $food_menu_ingredients = $this->db->query("SELECT * FROM tbl_food_menus_ingredients WHERE food_menu_id=$item->item_id")->result();
                         foreach($food_menu_ingredients as $single_ingredient){
                             $data_sale_consumptions_detail = array();
                             $data_sale_consumptions_detail['ingredient_id'] = $single_ingredient->ingredient_id;
                             $data_sale_consumptions_detail['consumption'] = $item->item_quantity*$single_ingredient->consumption;
                             $data_sale_consumptions_detail['sale_consumption_id'] = $sale_consumption_id;
                             $data_sale_consumptions_detail['sales_id'] = $sales_id;
                             $data_sale_consumptions_detail['food_menu_id'] = $item->item_id;
                             $data_sale_consumptions_detail['user_id'] = $this->session->userdata('outlet_id');
                             $data_sale_consumptions_detail['outlet_id'] = $this->session->userdata('outlet_id');
                             $data_sale_consumptions_detail['del_status'] = 'Live';
                             $this->db->insert('tbl_sale_consumptions_of_menus',$data_sale_consumptions_detail);
                         }
                     }else{
                         $combo_food_menus = $this->db->query("SELECT * FROM tbl_combo_food_menus WHERE food_menu_id=$item->item_id AND del_status='Live'")->result();
                         if(isset($combo_food_menus) && $combo_food_menus){
                             foreach ($combo_food_menus as $single_combo_fm){
                                 $food_menu_ingredients = $this->db->query("SELECT * FROM tbl_food_menus_ingredients WHERE food_menu_id=$single_combo_fm->added_food_menu_id")->result();
                                 foreach($food_menu_ingredients as $single_ingredient){
                                     $data_sale_consumptions_detail = array();
                                     $data_sale_consumptions_detail['ingredient_id'] = $single_ingredient->ingredient_id;
                                     $data_sale_consumptions_detail['consumption'] = $item->item_quantity * ($single_combo_fm->quantity*$single_ingredient->consumption);
                                     $data_sale_consumptions_detail['sale_consumption_id'] = $sale_consumption_id;
                                     $data_sale_consumptions_detail['sales_id'] = $sales_id;
                                     $data_sale_consumptions_detail['food_menu_id'] = $item->item_id;
                                     $data_sale_consumptions_detail['user_id'] = $this->session->userdata('outlet_id');
                                     $data_sale_consumptions_detail['outlet_id'] = $this->session->userdata('outlet_id');
                                     $data_sale_consumptions_detail['del_status'] = 'Live';
                                     $this->db->insert('tbl_sale_consumptions_of_menus',$data_sale_consumptions_detail);
                                 }
                             }

                         }
                     }

                     $exist_food_menu_modifier = getExistFoodMenuModifier($sale_id_old_sale_id,$item->item_id);
                     if(isset($exist_food_menu_modifier) && $exist_food_menu_modifier){
                         foreach($exist_food_menu_modifier as $key1=>$single_modifier_value){
                             $modifier_data = array();
                             $modifier_data['modifier_id'] =$single_modifier_value->modifier_id;
                             $modifier_data['modifier_price'] = $single_modifier_value->modifier_price;
                             $modifier_data['food_menu_id'] = $item->item_id;
                             $modifier_data['sales_id'] = $sales_id;
                             $modifier_data['sales_details_id'] = $sales_details_id;
                             $modifier_data['menu_taxes'] = $single_modifier_value->menu_taxes;
                             $modifier_data['user_id'] = $this->session->userdata('user_id');
                             $modifier_data['outlet_id'] = $this->session->userdata('outlet_id');
                             $modifier_data['customer_id'] =$order_details->customer_id;
                             $query = $this->db->insert('tbl_sales_details_modifiers', $modifier_data);

                             $modifier_ingredients = $this->db->query("SELECT * FROM tbl_modifier_ingredients WHERE modifier_id=$single_modifier_value->modifier_id")->result();

                             foreach($modifier_ingredients as $single_ingredient){
                                 $data_sale_consumptions_detail = array();
                                 $data_sale_consumptions_detail['ingredient_id'] = $single_ingredient->ingredient_id;
                                 $data_sale_consumptions_detail['consumption'] = $item->item_quantity*$single_ingredient->consumption;
                                 $data_sale_consumptions_detail['sale_consumption_id'] = $sale_consumption_id;
                                 $data_sale_consumptions_detail['sales_id'] = $sales_id;
                                 $data_sale_consumptions_detail['food_menu_id'] = $item->item_id;
                                 $data_sale_consumptions_detail['user_id'] = $this->session->userdata('user_id');
                                 $data_sale_consumptions_detail['outlet_id'] = $this->session->userdata('outlet_id');
                                 $data_sale_consumptions_detail['del_status'] = 'Live';
                                 $query = $this->db->insert('tbl_sale_consumptions_of_modifiers_of_menus',$data_sale_consumptions_detail);
                             }
                         }
                     }

                 }
            }
        }
        if($is_last_split==1){
            $status_update_array = array('order_status' => "3");
            $this->db->where('id', $sale_id_old_sale_id);
            $this->db->update('tbl_sales', $status_update_array);

            $status_update_array = array('del_status' => "Deleted");
            $this->db->where('id', $sale_id_old_sale_id);
            $this->db->update('tbl_sales', $status_update_array);

            $this->db->delete('tbl_sales_details', array('sales_id' => $sale_id_old_sale_id));
            $this->db->delete('tbl_sales_details_modifiers', array('sales_id' => $sale_id_old_sale_id));
            $this->db->delete('tbl_sale_consumptions', array('sale_id' => $sale_id_old_sale_id));
            $this->db->delete('tbl_sale_consumptions_of_menus', array('sales_id' => $sale_id_old_sale_id));
            $this->db->delete('tbl_sale_consumptions_of_modifiers_of_menus', array('sales_id' => $sale_id_old_sale_id));
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            echo escape_output($sales_id);
            $this->db->trans_commit();
        }

    }
    public function push_online(){
        $sale_id_offline = $this->input->post('sales_id');
        $order_details = json_decode(($this->input->post('orders')));
        $sale_no = $order_details->sale_no;
        $sale_id = '';
        $check_existing = getSaleDetailsBySaleNo($sale_no);
        $select_kitchen_row = getKitchenSaleDetailsBySaleNo($sale_no);

        if(isset($check_existing) && $check_existing){
            $sale_id = $check_existing->id; 
        }
      
        $data = array();
        $data['self_order_content'] = $this->input->post('orders');
        $data['customer_id'] = trim_checker($order_details->customer_id);
        $data['counter_id'] = trim_checker($order_details->counter_id);
        $data['delivery_partner_id'] = trim_checker($order_details->delivery_partner_id);
        $data['total_items'] = trim_checker($order_details->total_items_in_cart);
        $data['sub_total'] = trim_checker($order_details->sub_total);
        $data['charge_type'] = trim_checker($order_details->charge_type);
        $data['previous_due_tmp'] = trim_checker($order_details->previous_due_tmp);
        $data['vat'] = trim_checker($order_details->total_vat);
        $data['total_payable'] = trim_checker($order_details->total_payable);
        $data['total_item_discount_amount'] = trim_checker($order_details->total_item_discount_amount);
        $data['sub_total_with_discount'] = trim_checker($order_details->sub_total_with_discount);
        $data['sub_total_discount_amount'] = trim_checker($order_details->sub_total_discount_amount);
        $data['total_discount_amount'] = trim_checker($order_details->total_discount_amount);
        $data['tips_amount'] = trim_checker($order_details->tips_amount);
        $data['tips_amount_actual_charge'] = trim_checker($order_details->tips_amount_actual_charge);
        $data['delivery_charge'] = trim_checker($order_details->delivery_charge);
        $data['delivery_charge_actual_charge'] = trim_checker($order_details->delivery_charge_actual_charge);
        $data['sub_total_discount_value'] = trim_checker($order_details->sub_total_discount_value);
        $data['sub_total_discount_type'] = trim_checker($order_details->sub_total_discount_type);
        $data['given_amount'] = trim_checker($order_details->hidden_given_amount);
        $data['change_amount'] = trim_checker($order_details->hidden_change_amount);
        $data['token_number'] = trim_checker($order_details->token_number);
        $data['random_code'] = trim_checker(isset($order_details->random_code) && $order_details->random_code?$order_details->random_code:'');
        $data['user_id'] = $this->session->userdata('user_id');;
        $data['waiter_id'] = trim_checker($order_details->waiter_id);
        $data['outlet_id'] = $this->session->userdata('outlet_id');
        $data['company_id'] = $this->session->userdata('company_id');
        $data['sale_date'] = trim_checker(isset($order_details->open_invoice_date_hidden) && $order_details->open_invoice_date_hidden?$order_details->open_invoice_date_hidden:date('Y-m-d'));
        $data['date_time'] = date('Y-m-d H:i:s',strtotime($order_details->date_time));
        $data['order_time'] = date('Y-m-d H:i:s',strtotime($order_details->date_time));
        $data['paid_date_time'] = date('Y-m-d H:i:s');
        $data['order_status'] = 3;
        $data['orders_table_text'] = ($order_details->orders_table_text);
        $data['payment_method_id'] = trim_checker($order_details->payment_method_type);
        $data['paid_amount'] = trim_checker($order_details->paid_amount);
        $data['due_amount'] = trim_checker($order_details->due_amount);
        $data['zatca_value'] = trim_checker($order_details->zatca_invoice_value);
        $total_tax = 0;
        if(isset($order_details->sale_vat_objects) && $order_details->sale_vat_objects){
            foreach ($order_details->sale_vat_objects as $keys=>$val){
                $total_tax+=$val->tax_field_amount;
            }
        }
        $data['vat'] = $total_tax;
        $data['sale_vat_objects'] = json_encode($order_details->sale_vat_objects);
        $data['order_type'] = trim_checker($order_details->order_type);
        $this->db->trans_begin();
        if($sale_id>0){
            $data['modified'] = 'Yes';
            $this->db->where('id', $sale_id);
            $this->db->update('tbl_sales', $data);

            //end of send notification process
            $this->db->delete('tbl_sales_details', array('sales_id' => $sale_id));
            $this->db->delete('tbl_sales_details_modifiers', array('sales_id' => $sale_id));
            $this->db->delete('tbl_sale_consumptions', array('sale_id' => $sale_id));
            $this->db->delete('tbl_sale_consumptions_of_menus', array('sales_id' => $sale_id));
            $this->db->delete('tbl_sale_consumptions_of_modifiers_of_menus', array('sales_id' => $sale_id));
            $this->db->delete('tbl_sale_payments', array('sale_id' => $sale_id));
            $sales_id = $sale_id;

            if((int)$order_details->edit_sale_id){
                $paymentarray = array();
                $paymentarray['payment_id'] = 1;
                $paymentarray['payment_name'] = "Cash";
                $paymentarray['amount'] = $order_details->total_payable;
                $paymentarray['date_time'] = date('Y-m-d H:i:s');;
                $paymentarray['sale_id'] = $sales_id;
                $paymentarray['user_id'] = $this->session->userdata('user_id');
                $paymentarray['outlet_id'] = $data['outlet_id'] ;
                $paymentarray['counter_id'] = $this->session->userdata('counter_id');
                $this->Common_model->insertInformation($paymentarray, "tbl_sale_payments");
             }

        }else{
            $this->db->insert('tbl_sales', $data);
            $sales_id = $this->db->insert_id();
            $sale_no_update_array = array('sale_no' => $sale_no);
            $this->db->where('id', $sales_id);
            $this->db->update('tbl_sales', $sale_no_update_array);
        }
        foreach($order_details->orders_table as $single_order_table){
            $order_table_info = array();
            $order_table_info['persons'] = $single_order_table->persons;
            $order_table_info['booking_time'] = date('Y-m-d H:i:s');
            $order_table_info['sale_id'] = $sales_id;
            $order_table_info['sale_no'] = $sale_no;
            $order_table_info['outlet_id'] = $this->session->userdata('outlet_id');
            $order_table_info['table_id'] = $single_order_table->table_id;
            $this->db->insert('tbl_orders_table',$order_table_info);
        }
        $data_sale_consumptions = array();
        $data_sale_consumptions['sale_id'] = $sales_id;
        $data_sale_consumptions['user_id'] = $this->session->userdata('user_id');
        $data_sale_consumptions['outlet_id'] = $this->session->userdata('outlet_id');
        $data_sale_consumptions['del_status'] = 'Live';
        $this->db->insert('tbl_sale_consumptions',$data_sale_consumptions);
        $sale_consumption_id = $this->db->insert_id();

        if($sales_id>0 && count($order_details->items)>0){
            foreach($order_details->items as $item){
                $tmp_var_111 = isset($item->p_qty) && $item->p_qty && $item->p_qty!='undefined'?$item->p_qty:0;
                $tmp = $item->qty-$tmp_var_111;
                $tmp_var = 0;
                if($tmp>0){
                    $tmp_var = $tmp;
                }

                $food_details =  $this->Common_model->getDataById($item->food_menu_id, "tbl_food_menus");
                $item_data = array();
                $item_data['food_menu_id'] = $item->food_menu_id;
                $p_name = getParentNameOnly($food_details->parent_id);
                $item_data['menu_name'] = isset($p_name) ? $p_name . (isset($food_details->name) && $food_details->name ? " " . $food_details->name : '') : (isset($food_details->name) && $food_details->name ? $food_details->name : '');
                $item_data['qty'] = $item->qty;
                $item_data['tmp_qty'] = $tmp_var;
                $item_data['menu_price_without_discount'] = $item->menu_price_without_discount;
                $item_data['menu_price_with_discount'] = $item->menu_price_with_discount;
                $item_data['menu_combo_items'] = isset($item->menu_combo_items) && $item->menu_combo_items && $item->menu_combo_items!="undefined"?$item->menu_combo_items:'';
                $item_data['is_free_item'] = $item->is_free;
                $item_data['menu_unit_price'] = $item->menu_unit_price;
                $item_data['menu_taxes'] = json_encode($item->item_vat);
                $item_data['menu_discount_value'] = $item->menu_discount_value;
                $item_data['discount_type'] = $item->discount_type;
                $item_data['menu_note'] = isset($item->item_note) && $item->item_note?$item->item_note:'';
                $item_data['discount_reason'] = isset($item->discount_reason) && $item->discount_reason?$item->discount_reason:'';
                $item_data['discount_amount'] = $item->item_discount_amount;
                $item_data['item_type'] = ($this->Sale_model->getItemType($item->food_menu_id)->item_type=="Bar No")?"Kitchen Item":"Bar Item";
                $item_data['cooking_status'] = ($item->item_cooking_status=="")?NULL:$item->item_cooking_status;
                
                if(isset($select_kitchen_row->id) && $select_kitchen_row->id){
                    $kitchen_data = getKitchenItemDetails($select_kitchen_row->id,$item->food_menu_id);
                    $item_data['cooking_start_time'] = isset($kitchen_data->cooking_start_time) && $kitchen_data->cooking_start_time?$kitchen_data->cooking_start_time:'0000-00-00 00:00:00';
                    $item_data['cooking_done_time'] = isset($kitchen_data->cooking_done_time) && $kitchen_data->cooking_done_time?$kitchen_data->cooking_done_time:'0000-00-00 00:00:00';
                }else{
                    $item_data['cooking_start_time'] = ($item->item_cooking_start_time=="" || $item->item_cooking_start_time=="0000-00-00 00:00:00")?'0000-00-00 00:00:00':date('Y-m-d H:i:s',strtotime($item->item_cooking_start_time));
                    $item_data['cooking_done_time'] = ($item->item_cooking_done_time=="" || $item->item_cooking_done_time=="0000-00-00 00:00:00")?'0000-00-00 00:00:00':date('Y-m-d H:i:s',strtotime($item->item_cooking_done_time));
                }
               
                $item_data['previous_id'] = ($item->item_previous_id=="")?0:$item->item_previous_id;
                $item_data['sales_id'] = $sales_id;
                $item_data['user_id'] = $this->session->userdata('user_id');
                $item_data['outlet_id'] = $this->session->userdata('outlet_id');
                if($order_details->customer_id!=1){
                    $item_data['loyalty_point_earn'] = ($item->qty * getLoyaltyPointByFoodMenu($item->food_menu_id,''));
                }

                $item_data['del_status'] = 'Live';
                $this->db->insert('tbl_sales_details', $item_data);
                $sales_details_id = $this->db->insert_id();

                if($item->item_previous_id==""){
                    $previous_id_update_array = array('previous_id' => $sales_details_id);
                    $this->db->where('id', $sales_details_id);
                    $this->db->update('tbl_sales_details', $previous_id_update_array);
                }

                if(isset($food_details->product_type) && $food_details->product_type==1){
                    $food_menu_ingredients = $this->db->query("SELECT * FROM tbl_food_menus_ingredients WHERE food_menu_id=$item->food_menu_id")->result();
                    foreach($food_menu_ingredients as $single_ingredient){
                        $inline_total = $single_ingredient->cost;
                        $data_sale_consumptions_detail = array();
                        $data_sale_consumptions_detail['ingredient_id'] = $single_ingredient->ingredient_id;
                        $data_sale_consumptions_detail['consumption'] = $item->qty*$single_ingredient->consumption;
                        $data_sale_consumptions_detail['sale_consumption_id'] = $sale_consumption_id;
                        $data_sale_consumptions_detail['sales_id'] = $sales_id;
                        $data_sale_consumptions_detail['cost'] = $inline_total;
                        $data_sale_consumptions_detail['food_menu_id'] = $item->food_menu_id;
                        $data_sale_consumptions_detail['user_id'] = $this->session->userdata('outlet_id');
                        $data_sale_consumptions_detail['outlet_id'] = $this->session->userdata('outlet_id');
                        $data_sale_consumptions_detail['del_status'] = 'Live';
                        $query = $this->db->insert('tbl_sale_consumptions_of_menus',$data_sale_consumptions_detail);
                    }
                }else if(isset($food_details->product_type) && $food_details->product_type==3){
                    $food_menu_ingredients = $this->db->query("SELECT * FROM tbl_ingredients WHERE food_id=$item->food_menu_id")->result();
                    foreach($food_menu_ingredients as $single_ingredient){
                        $inline_total = $single_ingredient->consumption_unit_cost;
                        $data_sale_consumptions_detail = array();
                        $data_sale_consumptions_detail['ingredient_id'] = $single_ingredient->id;
                        $data_sale_consumptions_detail['consumption'] = $item->qty;
                        $data_sale_consumptions_detail['sale_consumption_id'] = $sale_consumption_id;
                        $data_sale_consumptions_detail['sales_id'] = $sales_id;
                        $data_sale_consumptions_detail['cost'] = $inline_total;
                        $data_sale_consumptions_detail['food_menu_id'] = $item->food_menu_id;
                        $data_sale_consumptions_detail['user_id'] = $this->session->userdata('outlet_id');
                        $data_sale_consumptions_detail['outlet_id'] = $this->session->userdata('outlet_id');
                        $data_sale_consumptions_detail['del_status'] = 'Live';
                         $this->db->insert('tbl_sale_consumptions_of_menus',$data_sale_consumptions_detail);
                    }
                }else{
                    $combo_food_menus = $this->db->query("SELECT * FROM tbl_combo_food_menus WHERE food_menu_id=$item->food_menu_id AND del_status='Live'")->result();
                    if(isset($combo_food_menus) && $combo_food_menus){
                        foreach ($combo_food_menus as $single_combo_fm){
                            $food_menu_ingredients = $this->db->query("SELECT * FROM tbl_food_menus_ingredients WHERE food_menu_id=$single_combo_fm->added_food_menu_id")->result();
                            foreach($food_menu_ingredients as $single_ingredient){
                                $inline_total = $single_ingredient->cost*($item->qty*$single_combo_fm->quantity);
                                $data_sale_consumptions_detail = array();
                                $data_sale_consumptions_detail['ingredient_id'] = $single_ingredient->ingredient_id;
                                $data_sale_consumptions_detail['consumption'] = ($item->qty*$single_combo_fm->quantity)*$single_ingredient->consumption;
                                $data_sale_consumptions_detail['sale_consumption_id'] = $sale_consumption_id;
                                $data_sale_consumptions_detail['sales_id'] = $sales_id;
                                $data_sale_consumptions_detail['cost'] = $inline_total;
                                $data_sale_consumptions_detail['food_menu_id'] = $item->food_menu_id;
                                $data_sale_consumptions_detail['user_id'] = $this->session->userdata('outlet_id');
                                $data_sale_consumptions_detail['outlet_id'] = $this->session->userdata('outlet_id');
                                $data_sale_consumptions_detail['del_status'] = 'Live';
                                $this->db->insert('tbl_sale_consumptions_of_menus',$data_sale_consumptions_detail);
                            }
                        }

                    }
                }



                $modifier_id_array = isset($item->modifiers_id) && ($item->modifiers_id!="")?explode(",",$item->modifiers_id):null;
                /*new_added_zak*/
                $modifiers_mul_id_array = isset($item->modifiers_mul_id) && ($item->modifiers_mul_id!="")?explode(",",$item->modifiers_mul_id):null;
                /*end_new_added_zak*/
                $modifier_price_array = isset($item->modifiers_price) && ($item->modifiers_price!="")?explode(",",$item->modifiers_price):null;
                $modifier_vat_array = (isset($item->modifier_vat) && $item->modifier_vat!="")?explode("|||",$item->modifier_vat):null;
                if(!empty($modifier_id_array)>0){
                    $i = 0;
                    foreach($modifier_id_array as $key1=>$single_modifier_id){
                        $modifiers_mul_id_array_value = isset($modifiers_mul_id_array[$key1]) && $modifiers_mul_id_array[$key1]?explode('_',$modifiers_mul_id_array[$key1]):'';

                        $modifier_data = array();
                        $modifier_data['modifier_id'] =$single_modifier_id;
                        $modifier_data['modifier_price'] = $modifier_price_array[$i];
                        $modifier_data['food_menu_id'] = $item->food_menu_id;
                        $modifier_data['sales_id'] = $sales_id;
                        $modifier_data['sales_details_id'] = $sales_details_id;
                        $modifier_data['menu_taxes'] = isset($modifier_vat_array[$key1]) && $modifier_vat_array[$key1]?$modifier_vat_array[$key1]:'';
                        $modifier_data['user_id'] = $this->session->userdata('user_id');
                        $modifier_data['outlet_id'] = $this->session->userdata('outlet_id');
                        $modifier_data['customer_id'] =$order_details->customer_id;
                        $this->db->insert('tbl_sales_details_modifiers', $modifier_data);

                        $modifier_ingredients = $this->db->query("SELECT * FROM tbl_modifier_ingredients WHERE modifier_id=$single_modifier_id")->result();

                        foreach($modifier_ingredients as $single_ingredient){
                            $data_sale_consumptions_detail = array();
                            $data_sale_consumptions_detail['ingredient_id'] = $single_ingredient->ingredient_id;
                            $data_sale_consumptions_detail['consumption'] = $item->qty*$single_ingredient->consumption;
                            $data_sale_consumptions_detail['sale_consumption_id'] = $sale_consumption_id;
                            $data_sale_consumptions_detail['sales_id'] = $sales_id;
                            $data_sale_consumptions_detail['food_menu_id'] = $item->food_menu_id;
                            $data_sale_consumptions_detail['user_id'] = $this->session->userdata('user_id');
                            $data_sale_consumptions_detail['outlet_id'] = $this->session->userdata('outlet_id');
                            $data_sale_consumptions_detail['del_status'] = 'Live';
                            $this->db->insert('tbl_sale_consumptions_of_modifiers_of_menus',$data_sale_consumptions_detail);
                        }
                        $i++;
                    }
                }
            }
        }

        if(!$sale_id){
            $this->db->delete('tbl_sale_payments', array('sale_id' => $sales_id));
        }
        //put payment details
        if(isset($order_details->payment_object)){
            if(isset($order_details->split_sale_id) && $order_details->split_sale_id){
                $payment_details = json_decode(($order_details->payment_object));
            }else{
                $payment_details = json_decode(json_decode($order_details->payment_object));
            }

            $currency_type = trim_checker($order_details->is_multi_currency);
            $multi_currency = trim_checker($order_details->multi_currency);
            $multi_currency_rate = trim_checker($order_details->multi_currency_rate);
            $multi_currency_amount = trim_checker($order_details->multi_currency_amount);
           

            if($currency_type==1){
                $check_existing_payment = getPaymentInfo($sales_id,1);
                if(!$check_existing_payment){
                    $data = array();
                    $data['payment_id'] = 1;
                    $data['payment_name'] = "Cash";
                    $data['amount'] = $multi_currency_amount;
                    $data['multi_currency'] = $multi_currency;
                    $data['multi_currency_rate'] = $multi_currency_rate;
                    $data['currency_type'] = $currency_type;
                    $data['date_time'] = date('Y-m-d H:i:s',strtotime($order_details->date_time));
                    $data['sale_id'] = $sales_id;
                    $data['counter_id'] = $this->session->userdata('counter_id');
                    $data['user_id'] = $this->session->userdata('user_id');
                    $data['outlet_id'] = $this->session->userdata('outlet_id');
                    $this->Common_model->insertInformation($data, "tbl_sale_payments");
                }
            }else{
                foreach ($payment_details as $value){
                    $check_existing_payment = getPaymentInfo($sales_id,$value->payment_id);
                    if(!$check_existing_payment){
                        $data = array();
                        $data['payment_id'] = $value->payment_id;
                        $data['payment_name'] = $value->payment_name;
                        if($value->payment_id==5){
                            $data['usage_point'] = $value->usage_point;
                            $previous_id_update_array = array('loyalty_point_earn' => 0);
                            $this->db->where('sales_id', $sales_id);
                            $this->db->update('tbl_sales_details', $previous_id_update_array);
                        }
                        $data['amount'] = $value->amount;
                        $data['date_time'] = date('Y-m-d H:i:s',strtotime($order_details->date_time));
                        $data['sale_id'] = $sales_id;
                        $data['counter_id'] = $this->session->userdata('counter_id');
                        $data['user_id'] = $this->session->userdata('user_id');
                        $data['outlet_id'] = $this->session->userdata('outlet_id');
                        $this->Common_model->insertInformation($data, "tbl_sale_payments");
                    }
                  
                }
            }
        }


        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $send_sms_status = isset($order_details->send_sms_status) && $order_details->send_sms_status?$order_details->send_sms_status:'';
            if($send_sms_status==1){
                $customer = getCustomerData(trim_checker($order_details->customer_id));
                $outlet_name = $this->session->userdata('outlet_name');
                $sms_content = "Hi ".$customer->name.", thank you for visiting '.$outlet_name.'. Total bill of your order on '.$order_details->date_time.' is ".getAmtCustom($order_details->total_payable).". Paid amount is: ".getAmtCustom($order_details->paid_amount).", Due Amount is: ".getAmtCustom($order_details->due_amount)."
We hope to see you again!";
                if($customer->phone){
                    smsSendOnly($sms_content,$customer->phone);
                }
            }
            if($select_kitchen_row){
                $pre_or_post_payment = $this->session->userdata('pre_or_post_payment');
                if($pre_or_post_payment==1){
                    $this->db->delete("tbl_kitchen_sales_details", array("sales_id" => $select_kitchen_row->id));
                    $this->db->delete("tbl_kitchen_sales_details_modifiers", array("sales_id" => $select_kitchen_row->id));
                    $this->db->delete("tbl_kitchen_sales", array("id" => $select_kitchen_row->id));
                }
            }
            echo escape_output($sale_id_offline);
            $this->db->trans_commit();
        }
    }
     /**
     * add sale by ajax
     * @access public
     * @return int
     * @param no
     */
    public function set_as_running_order(){
        $sale_no = $this->input->post('sale_no');
        $sale_details = getKitchenSaleDetailsBySaleNoWithDeleted($sale_no);

        $status = $this->input->post('status');
        $data = array();
        $data['is_self_order'] = "No";
        $data['is_online_order'] = "No";
        $data['is_accept'] = 1;
        $data['future_sale_status'] = $status;
        $data['self_order_status'] = "Approved";
        $this->db->where('id', $sale_details->id);
        $this->db->update('tbl_kitchen_sales', $data);
 
             
        $data_1['is_print'] = 1; 
        $this->db->where('sales_id ', $sale_details->id);
        $this->db->update('tbl_kitchen_sales_details', $data_1);


        $sale_object = $this->get_all_information_of_a_sale($sale_no);
        echo json_encode($sale_object);


    }
     /**
     * get new orders
     * @access public
     * @return object
     * @param no
     */
    public function get_new_orders_ajax(){
        $data1 = $this->get_new_orders();
        echo json_encode($data1);
    }
     /**
     * get new orders
     * @access public
     * @return object
     * @param no
     */
    public function get_new_orders(){
        $outlet_id = $this->session->userdata('outlet_id');
        $data1 = $this->Sale_model->getNewOrders($outlet_id);
        $i = 0;
        for($i;$i<count($data1);$i++){
            $data1[$i]->total_kitchen_type_items = $this->Sale_model->get_total_kitchen_type_items($data1[$i]->sale_id);
            $data1[$i]->total_kitchen_type_done_items = $this->Sale_model->get_total_kitchen_type_done_items($data1[$i]->sale_id);
            $data1[$i]->total_kitchen_type_started_cooking_items = $this->Sale_model->get_total_kitchen_type_started_cooking_items($data1[$i]->sale_id);
            $data1[$i]->tables_booked = $this->Sale_model->get_all_tables_of_a_sale_items($data1[$i]->sale_id);

            $to_time = strtotime(date('Y-m-d H:i:s'));
            $from_time = strtotime($data1[$i]->date_time);
            $minutes = floor(abs($to_time - $from_time) / 60);
            $seconds = abs($to_time - $from_time) % 60;

            $data1[$i]->minute_difference = str_pad(floor($minutes), 2, "0", STR_PAD_LEFT);
            $data1[$i]->second_difference = str_pad(floor($seconds), 2, "0", STR_PAD_LEFT);
        }
        return $data1;
    }
     /**
     * get all tables with new status
     * @access public
     * @return object
     * @param no
     */
    public function get_all_tables_with_new_status_ajax(){
        $outlet_id = $this->session->userdata('outlet_id');
        $tables = $this->Sale_model->getTablesByOutletId($outlet_id);
        $data1 = new \stdClass();
        $data1->table_details = $this->getTablesDetails($tables);
        $data1->table_availability = $this->Sale_model->getTableAvailability($outlet_id);
        echo json_encode($data1);
    }
     /**
     * get all information of a sale ajax
     * @access public
     * @return object
     * @param no
     */
    public function get_all_information_of_a_sale_ajax(){
        $sale_no = $this->input->post('sale_no');
        $sale_object = $this->get_all_information_of_a_sale($sale_no);
        echo json_encode($sale_object);
    }
     /**
     * get all information of a sale ajax
     * @access public
     * @return object
     * @param no
     */
    public function get_all_information_of_a_sale_ajax_modify(){
        $sales_id = $this->input->post('sale_id');
        $sale_object = $this->get_all_information_of_a_sale_modify($sales_id);
        echo json_encode($sale_object);
    }
     /**
     * get all information of a sale by table id
     * @access public
     * @return object
     * @param no
     */
    public function get_all_information_of_a_sale_by_table_id_ajax()
    {
        $table_id = $this->input->post('table_id');
        $sale_info = $this->Sale_model->get_new_sale_by_table_id($table_id);
        $sale_id = $sale_info->id;
        $sale_object = $this->get_all_information_of_a_sale($sale_info->sale_no);
        echo json_encode($sale_object);
    }
     /**
     * get all information of a sale
     * @access public
     * @return object
     * @param int
     */
    public function get_all_information_of_a_sale($sale_no){
        $sales_information = $this->get_all_information_of_a_sale_kitchen($sale_no);
       

        $sales_information->sub_total = getAmtP(isset($sales_information->sub_total) && $sales_information->sub_total?$sales_information->sub_total:0);
        $sales_information->paid_amount = getAmtP(isset($sales_information->paid_amount) && $sales_information->paid_amount?$sales_information->paid_amount:0);
        $sales_information->due_amount = getAmtP(isset($sales_information->due_amount) && $sales_information->due_amount?$sales_information->due_amount:0);
        $sales_information->vat = getAmtP(isset($sales_information->vat) && $sales_information->vat?$sales_information->vat:0);
        $sales_information->total_payable = getAmtP(isset($sales_information->total_payable) && $sales_information->total_payable?$sales_information->total_payable:0);
        $sales_information->total_item_discount_amount = getAmtP(isset($sales_information->total_item_discount_amount) && $sales_information->total_item_discount_amount?$sales_information->total_item_discount_amount:0);
        $sales_information->sub_total_with_discount = getAmtP(isset($sales_information->sub_total_with_discount) && $sales_information->sub_total_with_discount?$sales_information->sub_total_with_discount:0);
        $sales_information->sub_total_discount_amount = getAmtP(isset($sales_information->sub_total_discount_amount) && $sales_information->sub_total_discount_amount?$sales_information->sub_total_discount_amount:0);
        $sales_information->total_discount_amount = getAmtP(isset($sales_information->total_discount_amount) && $sales_information->total_discount_amount?$sales_information->total_discount_amount:0);
        $sales_information->delivery_charge = (isset($sales_information->delivery_charge) && $sales_information->delivery_charge?$sales_information->delivery_charge:0);
        $this_value = $sales_information->sub_total_discount_value;
        $disc_fields = explode('%',$this_value);
        $discP = isset($disc_fields[1]) && $disc_fields[1]?$disc_fields[1]:'';
        if ($discP == "") {
        } else {
            $sales_information->sub_total_discount_value = getAmtP(isset($sales_information->sub_total_discount_value) && $sales_information->sub_total_discount_value?$sales_information->sub_total_discount_value:0);
        }
        $items_by_sales_id = $this->Sale_model->getAllItemsFromSalesDetailBySalesIdKitchen($sales_information->id);

        foreach($items_by_sales_id as $single_item_by_sale_id){
            $modifier_information = $this->Sale_model->getModifiersBySaleAndSaleDetailsIdKitchen($sales_information->id,$single_item_by_sale_id->sales_details_id);
            $single_item_by_sale_id->modifiers = $modifier_information;

            $modifiers_id = '';
            $modifiers_name = '';
            $modifiers_price = '';
            foreach($modifier_information as $ky1=>$val){
                $modifiers_id.=$val->modifier_id;
                $modifiers_name.=$val->name;
                $modifiers_price.=$val->modifier_price;

                if($ky1<(sizeof($modifier_information))-1){
                    $modifiers_id.=",";
                    $modifiers_name.=",";
                    $modifiers_price.=",";
                }
            }
            $single_item_by_sale_id->modifiers_id = $modifiers_id;
            $single_item_by_sale_id->modifiers_name = $modifiers_name;
            $single_item_by_sale_id->modifiers_price = $modifiers_price;
            
        }
        $sales_details_objects = $items_by_sales_id;
        if(isset($sales_details_objects[0]) && $sales_details_objects[0]){
            $sales_details_objects[0]->menu_price_without_discount = getAmtP(isset($sales_details_objects[0]->menu_price_without_discount) && $sales_details_objects[0]->menu_price_without_discount?$sales_details_objects[0]->menu_price_without_discount:0);
            $sales_details_objects[0]->menu_price_with_discount = getAmtP(isset($sales_details_objects[0]->menu_price_with_discount) && $sales_details_objects[0]->menu_price_with_discount?$sales_details_objects[0]->menu_price_with_discount:0);
            $sales_details_objects[0]->menu_unit_price = getAmtP(isset($sales_details_objects[0]->menu_unit_price) && $sales_details_objects[0]->menu_unit_price?$sales_details_objects[0]->menu_unit_price:0);
            $sales_details_objects[0]->menu_vat_percentage = getAmtP(isset($sales_details_objects[0]->menu_vat_percentage) && $sales_details_objects[0]->menu_vat_percentage?$sales_details_objects[0]->menu_vat_percentage:0);
            $sales_details_objects[0]->discount_amount = getAmtP(isset($sales_details_objects[0]->discount_amount) && $sales_details_objects[0]->discount_amount?$sales_details_objects[0]->discount_amount:0);
    
            $this_value = $sales_details_objects[0]->menu_discount_value;
            $disc_fields = explode('%',$this_value);
            $discP = isset($disc_fields[1]) && $disc_fields[1]?$disc_fields[1]:'';
            if ($discP == "") {
            } else {
                $sales_details_objects[0]->menu_discount_value = getAmtP(isset($sales_details_objects[0]->menu_discount_value) && $sales_information->menu_discount_value?$sales_details_objects[0]->menu_discount_value:0);
            }
    
        }
      
        $sale_object = $sales_information;
        $sale_object->items = $sales_details_objects;
        $sale_object->tables_booked = '';
        return $sale_object;
    }
    public function get_all_information_of_a_sale_kitchen($sale_no){
        $sales_information = getKitchenSaleDetailsBySaleNoWithDeleted($sale_no);
        return $sales_information;
    }
     /**
     * get all information of a sale
     * @access public
     * @return object
     * @param int
     */
    public function get_all_information_of_a_sale_modify($sales_id){
        $sales_information = $this->Sale_model->getSaleBySaleId($sales_id);
       
        $sales_information[0]->sub_total = getAmtP(isset($sales_information[0]->sub_total) && $sales_information[0]->sub_total?$sales_information[0]->sub_total:0);
        $sales_information[0]->paid_amount = getAmtP(isset($sales_information[0]->paid_amount) && $sales_information[0]->paid_amount?$sales_information[0]->paid_amount:0);
        $sales_information[0]->due_amount = getAmtP(isset($sales_information[0]->due_amount) && $sales_information[0]->due_amount?$sales_information[0]->due_amount:0);
        $sales_information[0]->vat = getAmtP(isset($sales_information[0]->vat) && $sales_information[0]->vat?$sales_information[0]->vat:0);
        $sales_information[0]->total_payable = getAmtP(isset($sales_information[0]->total_payable) && $sales_information[0]->total_payable?$sales_information[0]->total_payable:0);
        $sales_information[0]->total_item_discount_amount = getAmtP(isset($sales_information[0]->total_item_discount_amount) && $sales_information[0]->total_item_discount_amount?$sales_information[0]->total_item_discount_amount:0);
        $sales_information[0]->sub_total_with_discount = getAmtP(isset($sales_information[0]->sub_total_with_discount) && $sales_information[0]->sub_total_with_discount?$sales_information[0]->sub_total_with_discount:0);
        $sales_information[0]->sub_total_discount_amount = getAmtP(isset($sales_information[0]->sub_total_discount_amount) && $sales_information[0]->sub_total_discount_amount?$sales_information[0]->sub_total_discount_amount:0);
        $sales_information[0]->total_discount_amount = getAmtP(isset($sales_information[0]->total_discount_amount) && $sales_information[0]->total_discount_amount?$sales_information[0]->total_discount_amount:0);
        $sales_information[0]->delivery_charge = (isset($sales_information[0]->delivery_charge) && $sales_information[0]->delivery_charge?$sales_information[0]->delivery_charge:0);
        $this_value = $sales_information[0]->sub_total_discount_value;
        $disc_fields = explode('%',$this_value);
        $discP = isset($disc_fields[1]) && $disc_fields[1]?$disc_fields[1]:'';
          if ($discP == "") {
          } else {
              $sales_information[0]->sub_total_discount_value = getAmtP(isset($sales_information[0]->sub_total_discount_value) && $sales_information[0]->sub_total_discount_value?$sales_information[0]->sub_total_discount_value:0);
          }
          
        $items_by_sales_id = $this->Sale_model->getAllItemsFromSalesDetailBySalesIdModify($sales_id);
        
        foreach($items_by_sales_id as $single_item_by_sale_id){
            $modifier_information = $this->Sale_model->getModifiersBySaleAndSaleDetailsId($sales_id,$single_item_by_sale_id->sales_details_id);
            $single_item_by_sale_id->modifiers = $modifier_information;
            $free_items = $this->Sale_model->getAllItemsFromSalesDetailBySalesIdModifyChild($single_item_by_sale_id->id,$sales_id);
            $single_item_by_sale_id->free_items = $free_items;
        }
        
        $sales_details_objects = $items_by_sales_id;
        $sales_details_objects[0]->menu_price_without_discount = getAmtP(isset($sales_details_objects[0]->menu_price_without_discount) && $sales_details_objects[0]->menu_price_without_discount?$sales_details_objects[0]->menu_price_without_discount:0);
        $sales_details_objects[0]->menu_price_with_discount = getAmtP(isset($sales_details_objects[0]->menu_price_with_discount) && $sales_details_objects[0]->menu_price_with_discount?$sales_details_objects[0]->menu_price_with_discount:0);
        $sales_details_objects[0]->menu_unit_price = getAmtP(isset($sales_details_objects[0]->menu_unit_price) && $sales_details_objects[0]->menu_unit_price?$sales_details_objects[0]->menu_unit_price:0);
        $sales_details_objects[0]->menu_vat_percentage = getAmtP(isset($sales_details_objects[0]->menu_vat_percentage) && $sales_details_objects[0]->menu_vat_percentage?$sales_details_objects[0]->menu_vat_percentage:0);
        $sales_details_objects[0]->discount_amount = getAmtP(isset($sales_details_objects[0]->discount_amount) && $sales_details_objects[0]->discount_amount?$sales_details_objects[0]->discount_amount:0);

        $this_value = $sales_details_objects[0]->menu_discount_value;
        $disc_fields = explode('%',$this_value);
        $discP = isset($disc_fields[1]) && $disc_fields[1]?$disc_fields[1]:'';
        if ($discP == "") {
        } else {
            $sales_details_objects[0]->menu_discount_value = getAmtP(isset($sales_details_objects[0]->menu_discount_value) && $sales_information[0]->menu_discount_value?$sales_details_objects[0]->menu_discount_value:0);
        }

        $sale_object = $sales_information[0];
        $sale_object->items = $sales_details_objects;
        $sale_object->tables_booked = $this->Sale_model->get_all_tables_of_a_sale_items($sales_id);
        return $sale_object;
    } 
     /**
     * print invoice
     * @access public
     * @return void
     * @param int
     */
    public function print_invoice($sale_id){
        
        $data['sale_object'] = $this->get_all_information_of_a_sale_modify($sale_id);
        
        $inv_qr_code_enable_status = $this->session->userdata('inv_qr_code_enable_status');
        $data['inv_qr_code_enable_status'] = $inv_qr_code_enable_status;
        
        $print_format = $this->session->userdata('print_format');
    
        //remove all old qrcode
        removeQrCode();
        //generate qrcode
        $url_patient = base_url().'invoice/'.$data['sale_object']->random_code;
        $rand_id = $sale_id;
        $this->load->library('phpqrcode/qrlib');
        $qr_codes_path = "qr_code/";
        $folder = $qr_codes_path;
        $file_name1 = $folder.$rand_id.".png";
        $file_name = $file_name1;
        QRcode::png($url_patient,$file_name,'',4,1);
        if($print_format=="80mm"){
            $this->load->view('sale/print_invoice', $data);
        }else{
            $this->load->view('sale/print_invoice_56mm', $data);
        }
    }
      
     /**
     * print bill
     * @access public
     * @return void
     * @param int
     */
    public function getBillDetails(){
        $sale_no = escape_output($_POST['sale_no']);
        $sale_object = $this->get_all_information_of_a_sale($sale_no);
        $order_type = '';
        if($sale_object->order_type == 1){
            $order_type = 'A';
        }elseif($sale_object->order_type == 2){
            $order_type = 'B';
        }elseif($sale_object->order_type == 3){
            $order_type = 'C';
        }
        $time = (date('H:i',strtotime($sale_object->order_time)));
        $tables = '';
        if(isset($sale_object->orders_table_text) && $sale_object->orders_table_text):
            $tables .= $sale_object->orders_table_text;
            endif;
        $html = '<header>';
             $invoice_logo = $this->session->userdata('invoice_logo');
              if($invoice_logo):
                $html.='<img src="'.base_url().'images/'.$invoice_logo.'">';
              endif;

              $html.='<h3 class="title">'.($this->session->userdata('outlet_name')).'</h3>
                    <p>'.lang('Bill_No').': <span id="b_bill_no">'.($order_type.' '.$sale_object->sale_no).'</span></p>
                </header>
                <ul class="simple-content">
                    <li>'.lang('date').': <span id="b_bill_date">'.(date($this->session->userdata('date_format'), strtotime($sale_object->sale_date))).' '.$time.' </span></li>
                    <li>'.lang('Sales_Associate').': <span id="b_bill_creator">'.($sale_object->user_name).'</span></li>
                    <li>'.lang('customer').': <b><span id="b_bill_customer">'.("$sale_object->customer_name").'</span></b></li>';
                     if(isset($sale_object->tables_booked) && $sale_object->tables_booked):
                         $html .='<li>'.lang('table').': <b><span id="b_bill_customer">'.$tables.'</span></b></li>';
                         endif;

                $html .='</ul>
                <ul class="main-content-list">';

                if (isset($sale_object->items)) {
                    $i = 1;
                    $totalItems = 0;
                    foreach ($sale_object->items as $row) {
                        $totalItems += $row->qty;
                        $menu_unit_price = getAmtP($row->menu_unit_price);
                        $html .= '<li>
                                <span># '.($i++).': '.$row->menu_name.' '.$row->qty.' X '.$menu_unit_price.'</span>
                                <span>'.(getAmt($row->menu_price_without_discount)).'</span>
                                </li>';
                    }
                }

                if(count($row->modifiers)){
                    $l = 1;
                    $html_modifier = '';
                    $modifier_price = 0;
                    foreach($row->modifiers as $modifier){
                        if($l==count($row->modifiers)){
                            $html_modifier .= escape_output($modifier->name);
                        }else{
                            $html_modifier .= escape_output($modifier->name).',';
                        }
                        $modifier_price+=$modifier->modifier_price;
                        $l++;
                    }
                    $html .= '<li>
                                <span>'.lang('modifier').' : '.$html_modifier.'</span>
                                <span>'.(getAmt($modifier_price)).'</span>
                                </li>';
                }
        $html .= '<li>
                        <span><b>'.lang('Total_Item_s').': <span id="b_bill_total_item">'.$totalItems.'</span></b></span>
                        <span></span>
                    </li>
                    <li>
                        <span>'.lang('sub_total').'</span>
                        <span><b><span id="b_bill_subtotal">'.(getAmt($sale_object->sub_total)).'</span></b></span>
                    </li>
                    <li>
                        <span>'.lang('grand_total').'</span>
                        <span><b><span id="b_bill_gtotal">'.(getAmt($sale_object->total_payable)).'</span></b></span>
                    </li>
                    <li>
                        <span>'.lang('total_payable').'</span>
                        <span><span id="b_bill_total_payable">'.(getAmt($sale_object->total_payable)).'</span></span>
                    </li>
                </ul>';

              echo json_encode($html);

    }
     /**
     * get new hold number
     * @access public
     * @return void
     * @param no
     */
    public function get_new_hold_number_ajax(){
        $number_of_holds_of_this_user_and_outlet = $this->get_current_hold();
        $number_of_holds_of_this_user_and_outlet++;
        /*This variable could not be escaped because this is html content*/
        echo $number_of_holds_of_this_user_and_outlet;
    }
     /**
     * get current hold
     * @access public
     * @return object
     * @param no
     */
    public function get_current_hold(){
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $number_of_holds = $this->Sale_model->getNumberOfHoldsByUserAndOutletId($outlet_id,$user_id);
        return $number_of_holds;
    }
     /**
     * add hold by ajax
     * @access public
     * @return void
     * @param int
     */
    public function add_hold_by_ajax()
    {
        $order_details = json_decode(json_decode($this->input->post('order')));
        $hold_number = trim_checker($this->input->post('hold_number'));
        $data = array();
        $data['customer_id'] = trim_checker($order_details->customer_id);
        $data['delivery_partner_id'] = trim_checker($order_details->delivery_partner_id);
        $data['total_items'] = trim_checker($order_details->total_items_in_cart);
        $data['sub_total'] = trim_checker($order_details->sub_total);
        $data['charge_type'] = trim_checker($order_details->charge_type);
        $data['table_id'] = trim_checker($order_details->selected_table);
        $data['total_payable'] = trim_checker($order_details->total_payable);
        $data['total_item_discount_amount'] = trim_checker($order_details->total_item_discount_amount);
        $data['sub_total_with_discount'] = trim_checker($order_details->sub_total_with_discount);
        $data['sub_total_discount_amount'] = trim_checker($order_details->sub_total_discount_amount);
        $data['total_discount_amount'] = trim_checker($order_details->total_discount_amount);
        $data['delivery_charge'] = trim_checker($order_details->delivery_charge);
        $data['delivery_charge_actual_charge'] = trim_checker($order_details->delivery_charge_actual_charge);
        $data['tips_amount'] = trim_checker($order_details->tips_amount);
        $data['tips_amount_actual_charge'] = trim_checker($order_details->tips_amount_actual_charge);

        $data['sub_total_discount_value'] = trim_checker($order_details->sub_total_discount_value);
        $data['sub_total_discount_type'] = trim_checker($order_details->sub_total_discount_type);
        $data['user_id'] = $this->session->userdata('user_id');
        $data['waiter_id'] = trim_checker($order_details->waiter_id);
        $data['outlet_id'] = $this->session->userdata('outlet_id');
        $data['sale_date'] = trim_checker(isset($order_details->open_invoice_date_hidden) && $order_details->open_invoice_date_hidden?$order_details->open_invoice_date_hidden:date('Y-m-d'));
        $data['sale_time'] = date('Y-m-d h:i A');
        $data['order_status'] = trim_checker($order_details->order_status);

        $total_tax = 0;
        if(isset($order_details->sale_vat_objects) && $order_details->sale_vat_objects){
            foreach ($order_details->sale_vat_objects as $keys=>$val){
                $total_tax+=$val->tax_field_amount;
            }
        }
        $data['vat'] = $total_tax;

        $data['sale_vat_objects'] = json_encode($order_details->sale_vat_objects);
        $data['order_type'] = trim_checker($order_details->order_type);
        if($hold_number===0 || $hold_number===""){
            $current_hold_order = $this->get_current_hold();
            echo "current hold".$current_hold_order."<br/>";
            $hold_number = $current_hold_order+1;
        }
        $data['hold_no'] = $hold_number;
        $query = $this->db->insert('tbl_holds', $data);
        $holds_id = $this->db->insert_id();
        if($holds_id>0 && count($order_details->items)>0){
            foreach($order_details->items as $item){
                $item_data = array();
                $item_data['food_menu_id'] = $item->item_id;
                $item_data['menu_name'] = $item->item_name;
                $item_data['qty'] = $item->item_quantity;
                $item_data['menu_price_without_discount'] = $item->item_price_without_discount;
                $item_data['menu_price_with_discount'] = $item->item_price_with_discount;
                $item_data['menu_unit_price'] = $item->item_unit_price;
                $item_data['menu_taxes'] = json_encode($item->item_vat);
                $item_data['menu_discount_value'] = $item->item_discount;
                $item_data['discount_type'] = $item->discount_type;
                $item_data['menu_note'] = $item->item_note;
                $item_data['discount_amount'] = $item->item_discount_amount;
                $item_data['holds_id'] = $holds_id;
                $item_data['user_id'] = $this->session->userdata('user_id');
                $item_data['outlet_id'] = $this->session->userdata('outlet_id');
                $item_data['del_status'] = 'Live';
                $query = $this->db->insert('tbl_holds_details', $item_data);
                $holds_details_id = $this->db->insert_id();

                $modifier_id_array = ($item->modifiers_id!="")?explode(",",$item->modifiers_id):null;
                $modifier_price_array = ($item->modifiers_price!="")?explode(",",$item->modifiers_price):null;
                $modifier_vat_array = ($item->modifier_vat!="")?explode("|||",$item->modifier_vat):null;

                if(!empty($modifier_id_array)>0){
                    $i = 0;
                    foreach($modifier_id_array as $key1=>$single_modifier_id){
                        $modifier_data = array();
                        $modifier_data['modifier_id'] =$single_modifier_id;
                        $modifier_data['modifier_price'] = $modifier_price_array[$i];
                        $modifier_data['food_menu_id'] = $item->item_id;
                        $modifier_data['holds_id'] = $holds_id;
                        $modifier_data['holds_details_id'] = $holds_details_id;
                        $modifier_data['menu_taxes'] = isset($modifier_vat_array[$key1]) && $modifier_vat_array[$key1]?$modifier_vat_array[$key1]:'';
                        $modifier_data['user_id'] = $this->session->userdata('user_id');
                        $modifier_data['outlet_id'] = $this->session->userdata('outlet_id');
                        $modifier_data['customer_id'] =$order_details->customer_id;
                        $query = $this->db->insert('tbl_holds_details_modifiers', $modifier_data);

                        $i++;
                    }
                }
            }
            foreach($order_details->orders_table as $single_order_table){
                $order_table_info = array();
                $order_table_info['persons'] = $single_order_table->persons;
                $order_table_info['booking_time'] = date('Y-m-d H:i:s');
                $order_table_info['hold_id'] = $holds_id;
                $order_table_info['hold_no'] = $hold_number;
                $order_table_info['outlet_id'] = $this->session->userdata('outlet_id');
                $order_table_info['table_id'] = $single_order_table->table_id;
                $this->db->insert('tbl_holds_table',$order_table_info);
            }
        }

        echo escape_output($holds_id);
    }
     /**
     * get all holds ajax
     * @access public
     * @return object
     * @param no
     */
    public function get_all_holds_ajax(){
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $holds_information = $this->Sale_model->getHoldsByOutletAndUserId($outlet_id,$user_id);
        foreach($holds_information as $key=>$single_hold_information){
            $holds_information[$key]->tables_booked = $this->Sale_model->get_all_tables_of_a_hold_items($single_hold_information->id);
        }
        echo json_encode($holds_information);
    }
     /**
     * get last 10 sales ajax
     * @access public
     * @return object
     * @param no
     */
    public function get_last_10_sales_ajax(){
        $outlet_id = $this->session->userdata('outlet_id');
        $sales_information = $this->Sale_model->getLastTenSalesByOutletAndUserId($outlet_id);
        foreach($sales_information as $single_sale_information){
            $single_sale_information->tables_booked = $this->Sale_model->get_all_tables_of_a_last_sale($single_sale_information->id);
        }
        echo json_encode($sales_information);
    }

    public function get_last_10_future_sales_ajax(){
        $outlet_id = $this->session->userdata('outlet_id');
        $sales_information = $this->Sale_model->future_sales($outlet_id);
        foreach($sales_information as $single_sale_information){
            $single_sale_information->tables_booked = $this->Sale_model->get_all_tables_of_a_last_sale($single_sale_information->id);
        }
        echo json_encode($sales_information);
    }
    public function get_last_10_self_order_sales_ajax(){
        $outlet_id = $this->session->userdata('outlet_id');
        $sales_information = $this->Sale_model->self_order_sales($outlet_id);
        if(isset($sales_information) && $sales_information){
            foreach($sales_information as $single_sale_information){
                $single_sale_information->tables_booked = $this->Sale_model->get_all_tables_of_a_last_sale($single_sale_information->id);
            }
        }

        echo json_encode($sales_information);
    }
    public function get_last_10_self_order_sales_ajax_admin(){
        $outlet_id = $this->session->userdata('outlet_id');
        $sales_self = $this->Sale_model->self_order_sales_admin($outlet_id);
        $sales_online = $this->Sale_model->online_order_sales_admin($outlet_id);
        $return_data['self_orders'] = $sales_self;
        $return_data['online_orders'] = $sales_online;
        echo json_encode($return_data);
    }
    public function set_as_running_order_decline(){
        $sale_no = $this->input->post('sale_no');
        $status = $this->input->post('status');

        $data = array();
        $data['is_self_order'] = "No";
        $data['is_online_order'] = "No";
        $data['future_sale_status'] = $status;
        $data['self_order_status'] = "Decline";
        $this->db->where('sale_no', $sale_no);
        $this->db->update('tbl_kitchen_sales', $data);
        echo json_encode("success");
    }
     /**
     * get single hold info by ajax
     * @access public
     * @return object
     * @param no
     */
    public function get_single_hold_info_by_ajax()
    {
        $hold_id = $this->input->post('hold_id');
        $hold_information = $this->Sale_model->get_hold_info_by_hold_id($hold_id);
        $items_by_holds_id = $this->Sale_model->getAllItemsFromHoldsDetailByHoldsId($hold_id);
        foreach($items_by_holds_id as $single_item_by_hold_id){
            $modifier_information = $this->Sale_model->getModifiersByHoldAndHoldsDetailsId($hold_id,$single_item_by_hold_id->holds_details_id);
            $single_item_by_hold_id->modifiers = $modifier_information;
        }
        $holds_details_objects = $items_by_holds_id;
        $hold_object = $hold_information[0];
        $hold_object->items = $holds_details_objects;
        $hold_object->tables_booked = json_encode($this->Sale_model->get_all_tables_of_a_hold_items($hold_id));
        echo json_encode($hold_object);

    }
     /**
     * delete all information of hold by ajax
     * @access public
     * @return object
     * @param no
     */
    public function delete_all_information_of_hold_by_ajax()
    {
        $hold_id = $this->input->post('hold_id');
        $this->db->delete('tbl_holds', array('id' => $hold_id));
        $this->db->delete('tbl_holds_details', array('holds_id' => $hold_id));
        $this->db->delete('tbl_holds_details_modifiers', array('holds_id' => $hold_id));
    }
     /**
     * check customer address ajax
     * @access public
     * @return object
     * @param no
     */
    public function check_customer_address_ajax()
    {
        $customer_id = $this->input->post('customer_id');
        $customer_info = $this->Sale_model->getCustomerInfoById($customer_id);
        echo json_encode($customer_info);
    }
     /**
     * get customer ajax
     * @access public
     * @return object
     * @param no
     */
    public function get_customer_ajax()
    {
        $customer_id = $this->input->post('customer_id');
        $customer_info = $this->Sale_model->getCustomerInfoById($customer_id);
        $customer_address = $this->Common_model->getAllByCustomId($customer_id,"customer_id","tbl_customer_address",$order='');
        $html = '';
        foreach ($customer_address as $value){
            $checked = '';
            if($value->is_active==1){
                $checked = "checked";
            }
            $html.='<tr><td><label class="pointer_class"><input type="radio" '.$checked.' data-id="'.$value->id.'" class="radio_class customer_del_address search_result_address" data-value="'.$value->address.'" name="customer_del_address"> '.$value->address.'</label></td></tr>';
        }
        $checked = '';
        $is_new_address = "No";
        if($html==''){
            $checked = "checked";
            $is_new_address = "Yes";
        }
        $html.='<tr><td><label class="pointer_class"><input type="radio" '.$checked.' data-id=="" class="radio_class customer_del_address search_result_address" data-value="New" name="customer_del_address"> New</label></td></tr>';

        $customer_info->is_new_address = $is_new_address;
        $customer_info->addresses = $html;
        echo json_encode($customer_info);
    }
     /**
     * cancel particular order
     * @access public
     * @return void
     * @param no
     */
    public function cancel_particular_order_ajax()
    {
        $sale_id = $this->input->post('sale_id');
        $event_txt = getSaleText($sale_id);
        putAuditLog($this->session->userdata('user_id'),$event_txt,"Cancelled Sale",date('Y-m-d H:i:s'));
        $this->delete_specific_order_by_sale_id($sale_id);
        echo "success";
    }
     /**
     * delete specific order by sale id
     * @access public
     * @return boolean
     * @param int
     */
    public function delete_specific_order_by_sale_id($sale_id){
        $this->db->delete('tbl_sales', array('id' => $sale_id));
        $this->db->delete('tbl_sales_details', array('sales_id' => $sale_id));
        $this->db->delete('tbl_sale_payments', array('sale_id' => $sale_id));
        $this->db->delete('tbl_sales_details_modifiers', array('sales_id' => $sale_id));
        $this->db->delete('tbl_sale_consumptions', array('sale_id' => $sale_id));
        $this->db->delete('tbl_sale_consumptions_of_menus', array('sales_id' => $sale_id));
        $this->db->delete('tbl_sale_consumptions_of_modifiers_of_menus', array('sales_id' => $sale_id));
        $this->db->delete('tbl_orders_table', array('sale_id' => $sale_id));
        return true;
    }
     /**
     * update order status ajax
     * @access public
     * @return void
     * @param int
     */
    public function update_order_status_ajax()
    {
        $payment_details = json_decode(json_decode($this->input->post('payment_object')));

        $sale_no = $this->input->post('sale_no');
        $close_order = $this->input->post('close_order');
        $paid_amount = $this->input->post('paid_amount');
        $due_amount = $this->input->post('due_amount');
        $given_amount_input = $this->input->post('given_amount_input');
        $change_amount_input = $this->input->post('change_amount_input');
        $payment_method_type = $this->input->post('payment_method_type');
        $currency_type = $this->input->post('is_multi_currency');
        $multi_currency = $this->input->post('multi_currency');
        $multi_currency_rate = $this->input->post('multi_currency_rate');
        $multi_currency_amount = $this->input->post('multi_currency_amount');


        $is_just_cloase = ($payment_method_type=='0')? true:false;

        $sale =getSaleDetails($sale_no);

        if($sale){
            $this->db->delete('tbl_sale_payments', array('sale_id' => $sale->id));

            if($currency_type==1){
                $data = array();
                $data['payment_id'] = 1;
                $data['payment_name'] = "Cash";
                $data['amount'] = $multi_currency_amount;
                $data['multi_currency'] = $multi_currency;
                $data['multi_currency_rate'] = $multi_currency_rate;
                $data['currency_type'] = $currency_type;
                $data['date_time'] = $sale->date_time;
                $data['sale_id'] = $sale->id;
                $data['counter_id'] = $this->session->userdata('counter_id');
                $data['user_id'] = $this->session->userdata('user_id');
                $data['outlet_id'] = $this->session->userdata('outlet_id');
                $this->Common_model->insertInformation($data, "tbl_sale_payments");
            }else{
                foreach ($payment_details as $value){
    
                    $data = array();
                    $data['payment_id'] = $value->payment_id;
                    $data['payment_name'] = $value->payment_name;
                        if($value->payment_id==5){
                            $data['usage_point'] = $value->usage_point;
    
                            $previous_id_update_array = array('loyalty_point_earn' => 0);
                            $this->db->where('sales_id', $sale->id);
                            $this->db->update('tbl_sales_details', $previous_id_update_array);
                        }
                    $data['amount'] = $value->amount;
                    $data['date_time'] = $sale->date_time;
                    $data['sale_id'] = $sale->id;
                    $data['counter_id'] = $this->session->userdata('counter_id');
                    $data['user_id'] = $this->session->userdata('user_id');
                    $data['outlet_id'] = $this->session->userdata('outlet_id');
                    $this->Common_model->insertInformation($data, "tbl_sale_payments");
                }
            }

            $sub_total_discount_finalize = $this->input->post('sub_total_discount_finalize');
            $total_payable = 0;
            $sub_total_discount_amount = 0;
            $total_discount_amount = 0;
    
            $sale_details = $this->Common_model->getDataById($sale->id, "tbl_sales");
            if((int)$sub_total_discount_finalize){
                $sub_total_discount_type = "fixed";
                $total_payable = $sale_details->total_payable - $sub_total_discount_finalize;
                $sub_total_discount_amount = $sale_details->sub_total_discount_amount + $sub_total_discount_finalize;
                $total_discount_amount = $sale_details->total_discount_amount + $sub_total_discount_finalize;
            }else{
                $sub_total_discount_type = "percentage";
                $total_payable = $sale_details->total_payable;
                $sub_total_discount_amount = $sale_details->sub_total_discount_amount;
                $total_discount_amount = $sale_details->total_discount_amount;
            }
    
            if($close_order=='true'){
                $this->Sale_model->delete_status_orders_table($sale->id);
                if($is_just_cloase){
                    $order_status = array('order_status' => 3,'total_payable' => $total_payable,'sub_total_discount_amount' => $sub_total_discount_amount,'total_discount_amount' => $total_discount_amount,'sub_total_discount_type' => $sub_total_discount_type,'given_amount' => $given_amount_input,'change_amount' => $change_amount_input,'close_time'=>date('H:i:s'));
                }else{
                    $order_status = array('paid_amount' =>  $paid_amount,'total_payable' => $total_payable,'sub_total_discount_amount' => $sub_total_discount_amount,'total_discount_amount' => $total_discount_amount,'sub_total_discount_type' => $sub_total_discount_type,'given_amount' => $given_amount_input,'change_amount' => $change_amount_input, 'due_amount' => $due_amount, 'order_status' => 3,'payment_method_id'=>$payment_method_type,'close_time'=>date('H:i:s'));
                }
            }else{
                $order_status = array('paid_amount' => $paid_amount,'total_payable' => $total_payable,'sub_total_discount_amount' => $sub_total_discount_amount,'total_discount_amount' => $total_discount_amount,'sub_total_discount_type' => $sub_total_discount_type,'given_amount' => $given_amount_input,'change_amount' => $change_amount_input,'due_amount' => $due_amount,'order_status' => 2,'payment_method_id'=>$payment_method_type);
            }
            $this->db->where('id', $sale->id);
            $this->db->update('tbl_sales', $order_status);
            echo escape_output($sale->id);


        }
     


    }
     /**
     * delete all holds with information by ajax
     * @access public
     * @return int
     * @param no
     */
    public function delete_all_holds_with_information_by_ajax()
    {
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $this->db->delete('tbl_holds', array('user_id' => $user_id,'outlet_id' => $outlet_id));
        $this->db->delete('tbl_holds_details', array('user_id' => $user_id,'outlet_id' => $outlet_id));
        $this->db->delete('tbl_holds_details_modifiers', array('user_id' => $user_id,'outlet_id' => $outlet_id));
        echo 1;
    }
     /**
     * change date of a sale ajax
     * @access public
     * @return void
     * @param no
     */
    public function change_date_of_a_sale_ajax()
    {
        $sale_id = $this->input->post('sale_id');
        $change_date = $this->input->post('change_date');
        $data['sale_date'] = date('Y-m-d',strtotime($change_date));
        $data['order_time'] = date("H:i:s");
        $changes = array(
            'sale_date' => date('Y-m-d',strtotime($change_date)),
            'order_time' => date("H:i:s"),
            'date_time' => date('Y-m-d H:i:s',strtotime($change_date.' '.date("H:i:s")))
        );

        $this->db->where('id', $sale_id);
        $this->db->update('tbl_sales', $changes);
    }
     /**
     * change date of a sale ajax
     * @access public
     * @return void
     * @param no
     */
    public function change_status_of_a_sale_ajax()
    {
        $sale_id = $this->input->post('sale_id');
        $status = $this->input->post('status');
        $data['status'] = $status;
        $changes = array(
            'status' => $status
        );

        $this->db->where('id', $sale_id);
        $this->db->update('tbl_sales', $changes);
    }
     /**
     * get Opening Balance
     * @access public
     * @return float
     * @param no
     */
	public function getOpeningBalance(){
        $counter_id = $this->session->userdata('counter_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $getOpeningBalance = $this->Sale_model->getOpeningBalance($counter_id,$outlet_id,$date);
        return isset($getOpeningBalance->amount) && $getOpeningBalance->amount?$getOpeningBalance->amount:'';
    }
     /**
     * get Opening Date Time
     * @access public
     * @return string
     * @param no
     */
    public function getOpeningDateTime(){
        $counter_id = $this->session->userdata('counter_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $getOpeningDateTime = $this->Sale_model->getOpeningDateTime($counter_id,$outlet_id,$date);
        return isset($getOpeningDateTime->opening_date_time) && $getOpeningDateTime->opening_date_time?$getOpeningDateTime->opening_date_time:'';
    }
     /**
     * get Opening Date Time
     * @access public
     * @return string
     * @param no
     */
    public function getOpeningDetails(){
        $counter_id = $this->session->userdata('counter_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $getOpeningDetails = $this->Sale_model->getOpeningDetails($counter_id,$outlet_id,$date);
        return isset($getOpeningDetails->opening_details) && $getOpeningDetails->opening_details?$getOpeningDetails->opening_details:'';
    }
     /**
     * get Closing Date Time
     * @access public
     * @return string
     * @param no
     */
    public function getClosingDateTime(){
        $counter_id = $this->session->userdata('counter_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $getClosingDateTime = $this->Sale_model->getClosingDateTime($counter_id,$outlet_id,$date);
        return isset($getClosingDateTime->closing_date_time) && $getClosingDateTime->closing_date_time?$getClosingDateTime->closing_date_time:'';
    }
     /**
     * get Purchase Paid Sum
     * @access public
     * @return float
     * @param no
     */
    public function getPurchasePaidSum(){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $summationOfPaidPurchase = $this->Sale_model->getSummationOfPaidPurchase($user_id,$outlet_id,$date);
        return $summationOfPaidPurchase->purchase_paid;
    }
     /**
     * get Supplier Payment Sum
     * @access public
     * @return float
     * @param no
     */
    public function getSupplierPaymentSum(){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $summationOfSupplierPayment = $this->Sale_model->getSummationOfSupplierPayment($user_id,$outlet_id,$date);
        return $summationOfSupplierPayment->payment_amount;
    }
     /**
     * get Customer Due Receive Amount Sum
     * @access public
     * @return float
     * @param string
     */
    public function getCustomerDueReceiveAmountSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $summationOfCustomerDueReceive = $this->Sale_model->getSummationOfCustomerDueReceive($user_id,$outlet_id,$date);
        return $summationOfCustomerDueReceive->receive_amount;
    }
     /**
     * get Expense Amount Sum
     * @access public
     * @return float
     * @param no
     */
    public function getExpenseAmountSum(){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $getExpenseAmountSum = $this->Sale_model->getExpenseAmountSum($user_id,$outlet_id,$date);
        return $getExpenseAmountSum->amount;
    }
     /**
     * get Sale Paid Sum
     * @access public
     * @return float
     * @param string
     */
    public function getSalePaidSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $getSalePaidSum = $this->Sale_model->getSalePaidSum($user_id,$outlet_id,$date);
        return $getSalePaidSum->amount;
    }
     /**
     * get Sale Due Sum
     * @access public
     * @return float
     * @param string
     */
    public function getSaleDueSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $getSaleDueSum = $this->Sale_model->getSaleDueSum($user_id,$outlet_id,$date);
        return $getSaleDueSum->amount;
    }
     /**
     * get Sale In Cash Sum
     * @access public
     * @return float
     * @param string
     */
    public function getSaleInCashSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $getSaleInCashSum = $this->Sale_model->getSaleInCashSum($user_id,$outlet_id,$date);
        return $getSaleInCashSum->amount;
    }
     /**
     * get Sale In Paypal Sum
     * @access public
     * @return float
     * @param string
     */
    public function getSaleInPaypalSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $getSaleInPaypalSum = $this->Sale_model->getSaleInPaypalSum($user_id,$outlet_id,$date);
        return $getSaleInPaypalSum->amount;
    }
     /**
     * get Sale In Card Sum
     * @access public
     * @return float
     * @param string
     */
    public function getSaleInCardSum($date){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $getSaleInCardSum = $this->Sale_model->getSaleInCardSum($user_id,$outlet_id,$date);
        return $getSaleInCardSum->amount;
    }
     /**
     * get Sale In Stripe Sum
      * @access public
      * @return float
      * @param string
     */
    public function getSaleInStripeSum(){
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $date = date('Y-m-d');
        $getSaleInStripeSum = $this->Sale_model->getSaleInStripeSum($user_id,$outlet_id,$date);
        return $getSaleInStripeSum->amount;
    }
     /**
     * get Payable Amount Sum
      * @access public
      * @return float
      * @param string
     */
    public function getPayableAomountSum($opening_date_time)
    {
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $getPayableAomountSum = $this->Sale_model->getPayableAomountSum($user_id,$outlet_id,$opening_date_time);
        return $getPayableAomountSum->amount;
    }
     /**
     * register Detail Calculation To Show
     * @access public
     * @return array
     * @param no
     */
    public function registerDetailCalculationToShow(){
        $opening_date_time = $this->getOpeningDateTime();
        $opening_details= $this->getOpeningDetails();

        $opening_details_decode = json_decode($opening_details);

        $html_content = '<table id="datatable" class="table_register_details top_margin_15"> <thead>
        <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr> </thead>
                    <tbody>
                    <tr>
                        <th>'.lang('counter').' '.lang('name').'</th>
                        <th>'.getCounterName($this->session->userdata('counter_id')).'</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                            <th>'.lang('Time_Range').'</th>
                            <th>'.(date("Y-m-d h:m:s A",strtotime($opening_date_time))).' to '.(date("Y-m-d h:i:s A")).'</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <th>&nbsp;</th>
                            <th class="text_right">&nbsp;</th>
                        </tr>
                        <tr>
                            <th>'.lang('sn').'</th>
                            <th>'.lang('payment_method').'</th>
                            <th>'.lang('Transactions').'</th>
                            <th class="text_right">'.lang('amount').'</th>
                        </tr>';
        $array_p_name = array();
        $array_p_amount = array();
        if(isset($opening_details_decode) && $opening_details_decode){
            foreach ($opening_details_decode as $key=>$value){
                $key++;
                $payments = explode("||",$value);

                $total_purchase = $this->Sale_model->getAllPurchaseByPayment($opening_date_time,$payments[0]);
                $total_due_receive = $this->Sale_model->getAllDueReceiveByPayment($opening_date_time,$payments[0]);
                $total_due_payment = $this->Sale_model->getAllDuePaymentByPayment($opening_date_time,$payments[0]);
                $total_expense = $this->Sale_model->getAllExpenseByPayment($opening_date_time,$payments[0]);
                $refund_amount = $this->Sale_model->getAllRefundByPayment($opening_date_time,$payments[0]);
                 
                $total_sale =  $this->Sale_model->getAllSaleByPayment($opening_date_time,$payments[0]);

                $inline_total = $payments[2] - $total_purchase + $total_sale  + $total_due_receive - $total_due_payment - $total_expense - $refund_amount;

                $array_p_name[] = $payments[1];
                $array_p_amount[] = $inline_total;

                $html_content .= '<tr>
                            <td>'.$key.'</td>
                            <td>'.$payments[1].'</td>
                            <td>'.lang('register_detail_1').'</td>
                            <td class="text_right">'.getAmtPCustom($payments[2]).'</td>
                        </tr>
                        
                        <tr>
                            <td></td>
                            <td></td>
                            <td>'.lang('register_detail_2').'</td>
                            <td class="text_right">'.getAmtPCustom($total_purchase).'</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>'.lang('register_detail_3').'</td>
                            <td class="text_right">'.getAmtPCustom($total_sale).'</td>
                        </tr>';
                if($payments[0]==1):
                    $total_sale_mul_c_rows =  $this->Sale_model->getAllSaleByPaymentMultiCurrencyRows($opening_date_time,$payments[0]);

                    if($total_sale_mul_c_rows){
                        foreach ($total_sale_mul_c_rows as $value1):
                            $html_content .= '<tr>
                                        <td></td>
                                        <td></td>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;'.$value1->multi_currency.'</td>
                                        <td class="text_right">'.getAmtPCustom($value1->total_amount).'</td>
                                    </tr>';
                        endforeach;

                    }

                endif;
                $html_content .= '<tr>
                            <td></td>
                            <td></td>
                            <td>'.lang('register_detail_5').'</td>
                            <td class="text_right">'.getAmtPCustom($total_due_receive).'</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>'.lang('register_detail_6').'</td>
                            <td class="text_right">'.getAmtPCustom($total_due_payment).'</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>'.lang('register_detail_7').'</td>
                            <td class="text_right">'.getAmtPCustom($total_expense).'</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>'.lang('refund_amount').'(-)</td>
                            <td class="text_right">'.getAmtPCustom($refund_amount).'</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <th>'.lang('closing_balance').'</th>
                            <th class="text_right">'.getAmtPCustom($inline_total).'</th>
                        </tr>
                         <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <th>&nbsp;</th>
                            <th class="text_right">&nbsp;</th>
                        </tr>';
            }
        }

        $html_content .= '<tr>
                                <th></th>
                                <th></th>
                                <th>'.lang('summary').'</th>
                                <th></th>
                        </tr>';
        $html_content .= '<tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <th>&nbsp;</th>
                            <th class="text_right">&nbsp;</th>
                        </tr>';
        foreach ($array_p_name as $key=>$value){
            $html_content .= '<tr>
                                <th></th>
                                <th></th>
                                <th>'.$value.'</th>
                                <th class="text_right">'.getAmtPCustom($array_p_amount[$key]).'</th>
                        </tr>';
        }


        $html_content.='</tbody>
                    </table>';


        $register_detail = array(
            'opening_date_time' => date('Y-m-d h:m A', strtotime($opening_date_time)),
            'closing_date_time' => $this->getClosingDateTime(),
            'html_content_for_div' => $html_content,
        );
        return $register_detail;
    }
     /**
     * get Balance
     * @access public
     * @return float
     * @param no
     */
    public function getBalance(){
        $opening_date_time = $this->getOpeningDateTime();
        $balance = $this->getOpeningBalance()+$this->getSalePaidSum($opening_date_time)+$this->getCustomerDueReceiveAmountSum($opening_date_time);
        return  $balance;
    }
     /**
     * register Detail Calculation To Show Ajax
     * @access public
     * @return object
     * @param no
     */
    public function registerDetailCalculationToShowAjax(){
        $all_register_info_values = $this->registerDetailCalculationToShow();
        // return $all_register_info_values;
        echo json_encode($all_register_info_values);
    }
     /**
     * print All Calculation
     * @access public
     * @return void
     * @param no
     */
    public function printAllCalculation()
    {
        //generate html content for view
        echo 'opening balance: '.$this->getOpeningBalance().'<br/>';
        echo 'purchase paid sum: '.$this->getPurchasePaidSum().'<br/>';
        echo 'supplier payment sum: '.$this->getSupplierPaymentSum().'<br/>';
        echo 'customer due receive amount sum: '.$this->getCustomerDueReceiveAmountSum("").'<br/>';
        echo 'expense amount sum: '.$this->getExpenseAmountSum().'<br/>';
        echo 'sale amount sum: '.$this->getSaleAmountSum().'<br/>';
        echo 'sale in cash sum: '.$this->getSaleInCashSum("").'<br/>';
        echo 'sale in paypal sum: '.$this->getSaleInPaypalSum("").'<br/>';
        // echo 'sale in paypal sum: '.$this->getSaleInPaypalSum().'<br/>';
        echo 'sale in card sum: '.$this->getSaleInCardSum("").'<br/>';
        echo 'sale in stripe sum: '.$this->getSaleInStripeSum().'<br/>';
    }
     /**
     * close Register
     * @access public
     * @return void
     * @param no
     */
    public function closeRegister()
    {
        $counter_id = $this->session->userdata('counter_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $opening_date_time = $this->getOpeningDateTime();


        $opening_details= $this->getOpeningDetails();

        $opening_details_decode = json_decode($opening_details);
        $total_closing = 0;

        $total_sale_all = 0;
        $total_purchase_all = 0;
        $total_refund_all = 0;
        $total_due_receive_all = 0;
        $total_due_payment_all = 0;
        $total_expense_all = 0;

        $payment_details = array();
        $others_currency = array();
        foreach ($opening_details_decode as $key=>$value){
            $payments = explode("||",$value);

            
            $total_sale =  $this->Sale_model->getAllSaleByPayment($opening_date_time,$payments[0]);
            $total_purchase = $this->Sale_model->getAllPurchaseByPayment($opening_date_time,$payments[0]);
            $total_due_receive = $this->Sale_model->getAllDueReceiveByPayment($opening_date_time,$payments[0]);
            $total_due_payment = $this->Sale_model->getAllDuePaymentByPayment($opening_date_time,$payments[0]);
            $total_expense = $this->Sale_model->getAllExpenseByPayment($opening_date_time,$payments[0]);
            $refund_amount = $this->Sale_model->getAllRefundByPayment($opening_date_time,$payments[0]);

            $total_sale_all += $total_sale;
            $total_purchase_all += $total_purchase;
            $total_refund_all += $refund_amount;
            $total_due_receive_all += $total_due_receive;
            $total_due_payment_all += $total_due_payment;
            $total_expense_all += $total_expense;
            $inline_closing = ($payments[2] - $total_purchase + $total_sale  + $total_due_receive - $total_due_payment - $total_expense - $refund_amount);
            $total_closing += $inline_closing;

            $preview_amount = isset($payment_details[$payments[1]]) && $payment_details[$payments[1]]?$payment_details[$payments[1]]:0;
            $payment_details[$payments[1]] = $preview_amount + $inline_closing;

            if($payments[0]==1):
                $total_sale_mul_c_rows =  $this->Sale_model->getAllSaleByPaymentMultiCurrencyRows($opening_date_time,$payments[0]);
                if($total_sale_mul_c_rows){
                    foreach ($total_sale_mul_c_rows as $value1):
                        $tmp_arr = array();
                        $tmp_arr['payment_name'] = $value1->multi_currency;
                        $tmp_arr['amount'] = getAmtPCustom($value1->total_amount);
                        $others_currency[] = $tmp_arr;
                    endforeach;
                }
           endif;
        }


        $changes = array(
            'closing_balance' => $total_closing,
            'closing_balance_date_time' => date("Y-m-d H:i:s"),
            'customer_due_receive' => $total_due_receive_all,
            'total_purchase' => $total_purchase_all,
            'refund_amount' => $total_refund_all,
            'total_due_payment' => $total_due_payment_all,
            'total_expense' => $total_expense_all,
            'sale_paid_amount' => $total_sale_all,
            'others_currency' => json_encode($others_currency),
            'payment_methods_sale' => json_encode($payment_details),
            'register_status' => 2
        );

        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('counter_id', $counter_id);
        $this->db->where('opening_balance_date_time', $opening_date_time);
        $this->db->where('register_status', 1);
        $this->db->update('tbl_register', $changes);
    }
     /**
     * get new notification
     * @access public
     * @return object
     * @param no
     */
    public function get_new_notification()
    {
        $outlet_id = $this->session->userdata('outlet_id');
        $notifications = $this->Sale_model->getNotificationByOutletId($outlet_id);
        return $notifications;
    }
     /**
     * get new notifications ajax
     * @access public
     * @return object
     * @param no
     */
    public function get_new_notifications_ajax()
    {
        echo json_encode($this->get_new_notification());
    }
     /**
     * remove notification
     * @access public
     * @return int
     * @param no
     */
    public function remove_notication_ajax()
    {
        $notification_id = $this->input->post('notification_id');
        $this->db->delete('tbl_notifications', array('id' => $notification_id));
        echo escape_output($notification_id);
    }
     /**
     * remove multiple notification
     * @access public
     * @return void
     * @param no
     */
    public function remove_multiple_notification_ajax()
    {
        $notifications = $this->input->post('notifications');
        $notifications_array = explode(",",$notifications);
        foreach($notifications_array as $single_notification){
            $this->db->delete('tbl_notifications', array('id' => $single_notification));
        }
    }

     /**
     * add temp bot
     * @access public
     * @return int
     * @param no
     */
    public function getTotalLoyaltyPoint()
    {
        $customer_id = json_decode($this->input->post('customer_id'));
        if($customer_id==1){
            $data['status'] = false;
            $data['alert_txt'] = lang('loyalty_point_not_applicable_for_walk_in_customer');
        }else{
            $data['status'] = true;
        }

        $return_data = getTotalLoyaltyPoint($customer_id,$this->session->userdata('outlet_id'));
        $available_point = $return_data[1];

        $data['total_point'] = $available_point;

        echo json_encode($data);
    }
     /**
     * remove a table booking ajax
     * @access public
     * @return object
     * @param no
     */
    public function remove_a_table_booking_ajax()
    {
        $orders_table_id = $this->input->post('orders_table_id');
        $orders_table_single_info = $this->Common_model->getDataById($orders_table_id, "tbl_orders_table");
        $this->db->delete('tbl_orders_table', array('id' => $orders_table_id));
        echo json_encode($orders_table_single_info);
    }
     /**
     * get all assets info by ajax
     * @access public
     * @return object
     * @param no
     */
    public function get_all_assets_info_by_ajax()
    {
        $outlet_id = $this->session->userdata('outlet_id');
        // echo $outlet_id;
        $assets = $this->Sale_model->get_all_assets($outlet_id);
        $data = new \stdClass();
        $data->assets_info = $this->assets_details($assets);
        echo json_encode($data);
    }
     /**
     * assets details
     * @access public
     * @return object
     * @param string
     */
    public function assets_details($assets)
    {
        foreach($assets as $asset){
            $asset->asset_games = $this->Sale_model->getGamesOfAssetByAssetId($asset->id);
        }
        return $assets;
    }
 
    /**
     * get Waiter Orders
     * @access public
     * @return object
     * @param no
     */
    public function getWaiterOrders(){
        $return_data = array();
        $get_waiter_orders = $this->Common_model->getWaiterOrders();
        $get_waiter_invoice_orders = $this->Common_model->getWaiterInvoiceOrders();
        $get_waiter_orders_for_update_sender = $this->Common_model->getWaiterOrdersForUpdateSender();
        $get_waiter_orders_for_update_receiver = $this->Common_model->getWaiterOrdersForUpdateReceiver();
        $get_waiter_orders_for_delete_sender = $this->Common_model->getWaiterOrdersForDeleteSender();
        $already_invoiced_orders = $this->Common_model->alreadyInvoicedOrders();
        $user_id = $this->session->userdata('user_id');

        $return_data['get_waiter_orders'] = $get_waiter_orders;
        $return_data['get_waiter_invoice_orders'] = $get_waiter_invoice_orders;
        $return_data['get_waiter_orders_for_update_sender'] = $get_waiter_orders_for_update_sender;
        $return_data['get_waiter_orders_for_update_receiver'] = $get_waiter_orders_for_update_receiver;
        $return_data['get_waiter_orders_for_delete_sender'] = $get_waiter_orders_for_delete_sender; 
        $return_data['already_invoiced_orders'] = $already_invoiced_orders;
        
        echo json_encode($return_data);
    }
    public function get_all_running_order_for_new_pc(){
        $user_id = $this->session->userdata('user_id');
        $return_data = array(); 
        $return_data['get_all_running_order_for_new_pc'] = get_all_running_order_for_new_pc($user_id); 
        echo json_encode($return_data);
    }
    public function getOrderedTable(){
        $getOrderedTable = $this->Common_model->getOrderedTable();
        echo json_encode($getOrderedTable);
    }

    /**
     * get Waiter Invoice Orders
     * @access public
     * @return object
     * @param no
     */
    public function getWaiterInvoiceOrders(){
        $waiter_database = $this->Common_model->getWaiterInvoiceOrders();
        echo json_encode($waiter_database);
    }

    /**
     * set Order Pulled
     * @access public
     * @return void
     * @param no
     */
    public function setOrderPulled(){
        $sale_id = escape_output($_POST['sale_id']);
        $role = $this->session->userdata('role');
        $designation = $this->session->userdata('designation');
        if($role=="Admin"){
            $data['pull_update_admin'] = 2;
        }else{
            if($designation=="Cashier"){
                $data['pull_update_cashier'] = 2;
            }else{
                $data['pull_update'] = 2;
            }
        }

        $this->db->where('id', $sale_id);
        $this->db->update('tbl_kitchen_sales', $data);
    }

    /**
     * set Order Invoice Pulled
     * @access public
     * @return void
     * @param no
     */
    public function setOrderInvoicePulled(){
        $sale_id = escape_output($_POST['sale_id']);
        $role = $this->session->userdata('role');
        $designation = $this->session->userdata('designation');
        if($role=="Admin"){
            $data['pull_update_admin'] = 3;
            $data['pull_update'] = 2;
            $data['is_delete_receiver'] = 1;
        }else{
            if($designation=="Cashier"){
                $data['pull_update_cashier'] = 3;
                $data['pull_update'] = 2;
            }else{
                $data['pull_update'] = 3;
            }
        }
        $this->db->where('id', $sale_id);
        $this->db->update('tbl_kitchen_sales', $data);
    }
    /**
     * set Order Invoice Updated
     * @access public
     * @return void
     * @param no
     */
    public function setOrderInvoiceUpdated(){
        $sale_id = escape_output($_POST['sale_id']);
        $type = escape_output($_POST['type']);
        if($type==1){
            $data['is_update_sender'] = 3;
        }else{
            $role = $this->session->userdata('role');
            if($role=="Admin"){
                $data['is_update_receiver_admin'] = 3;
            }else{
                $data['is_update_receiver'] = 3;
            }
        }
        $this->db->where('id', $sale_id);
        $this->db->update('tbl_kitchen_sales', $data);
    }
    public function removePulledData(){
        $id = escape_output($_POST['id']);
        $this->db->delete("tbl_running_orders", array("id" => $id));
    }
    public function removePulledTableData(){
        $sale_no = escape_output($_POST['sale_no']);
        $this->db->delete("tbl_running_order_tables", array("sale_no" => $sale_no));
    }
    public function remove_table(){
        $sale_no = escape_output($_POST['sale_no']);
        $table_id = escape_output($_POST['table_id']);
        $this->db->delete("tbl_running_order_tables", array("sale_no" => $sale_no,"table_id" => $table_id));
        echo json_encode("success");
    }
    /**
     * set Order Invoice Deleted
     * @access public
     * @return void
     * @param no
     */
    public function setOrderInvoiceDeleted(){
        $sale_id = escape_output($_POST['sale_id']);
        $type = escape_output($_POST['type']);
        if($type==1){
            $data['is_delete_sender'] = 3;
        }else{
            $role = $this->session->userdata('role');
            if($role=="Admin"){
                $data['is_deletxe_receiver_admin'] = 3;
            }else{
                $data['is_delete_receiver'] = 3;
            }
        }
        $this->db->where('id', $sale_id);
        $this->db->update('tbl_kitchen_sales', $data);
    }
    public function setMergeDelete(){
            $sale_no = escape_output($_POST['sale_no']);
            $select_kitchen_row = getKitchenSaleDetailsBySaleNo($sale_no);
            if($select_kitchen_row){
                $this->db->delete("tbl_kitchen_sales_details", array("sales_id" => $select_kitchen_row->id));
                $this->db->delete("tbl_kitchen_sales_details_modifiers", array("sales_id" => $select_kitchen_row->id));
                $this->db->delete("tbl_kitchen_sales", array("id" => $select_kitchen_row->id));
            }

            echo 'success';
        }
    /**
     * get data for ajax datatale
     * @access public
     * @return json
     */
    public function getAjaxData() {
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $sales = $this->Sale_model->make_datatables($outlet_id);
        $data = array();

        if ($sales && !empty($sales)) {
            $i = count($sales);
        }
        $row_count = 0;
        foreach ($sales as $value){
            if($value->del_status=="Live"):
                $order_type = "";
                if($value->order_type=='1'){
                    $order_type = "Dine In";
                }elseif($value->order_type=='2'){
                    $order_type = "Take Away";
                }elseif($value->order_type=='3'){
                    $order_type = "Delivery";
                }
                $row_count++;
                $html = '';

                $html .= '<a data-access="refund-123" class="btn btn-deep-purple menu_assign_class" href="'.base_url().'Sale/refund/'.($this->custom->encrypt_decrypt($value->id, 'encrypt')).'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'.lang('refund').'">
                <i class="fas fa-money-bill-alt"></i>
                </a>';

                $html .= '<a data-access="view_invoice-123" class="btn btn-unique menu_assign_class" onclick="viewInvoice('.$value->id.')" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'.lang('view_invoice').'">
                <i class="fas fa-print"></i>
                </a>';

               if($order_type=="Delivery"):
                $html .= '<a data-access="change_delivery_address-123" class="btn btn-cyan menu_assign_class change_delivery_details" data-status="'.escape_output($value->status).'" data-id="'.escape_output($value->id).'" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'.lang('change_delivery_address').'">
                 <i class="fa fa-truck tiny-icon"></i>
                </a>';
               endif;

                $html .= '<a data-access="view_invoice-123" class="btn btn-warning menu_assign_class" href="'.base_url().'Sale/POS/'.$user_id.'/'.$outlet_id.'/'.$value->id.'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'.lang('edit_sale').'">
                 <i class="far fa-edit"></i>
                </a>';

                $html .= '<a class="delete btn btn-danger menu_assign_class" href="'.base_url().'Sale/deleteSale/'.($this->custom->encrypt_decrypt($value->id, 'encrypt')).'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'.lang('delete').'">
                 <i class="fa-regular fa-trash-can"></i>
                </a>';

                $sub_array =  array();
                $sub_array[] = escape_output($i--);
                $sub_array[] = escape_output($value->sale_no);
                $sub_array[] = escape_output($order_type);
                $sub_array[] = escape_output(date($this->session->userdata['date_format'], strtotime($value->sale_date)))." ".escape_output($value->order_time);
                $sub_array[] = escape_output($value->customer_name).''.escape_output($value->customer_phone?' ('.$value->customer_phone.')':'');
                $sub_array[] = escape_output(getAmtPCustom($value->total_payable));
                $sub_array[] = (($value->total_refund?escape_output(getAmtPCustom($value->total_refund)).' <i data-id="'.$value->id.'" class="fa fa-eye getDetailsRefund pointer_class"></i>':''));
                    $payment_details = '';
                    $outlet_id = $this->session->userdata('outlet_id');
                    $salePaymentDetails = salePaymentDetails($value->id,$outlet_id);
                    if(isset($salePaymentDetails) && $salePaymentDetails):
                        foreach ($salePaymentDetails as $ky=>$payment):
                        $txt_point = '';
                        if($payment->id==5){
                            $txt_point = " (Usage Point:".$payment->usage_point.")";
                        }
                        $payment_details.=(escape_output($payment->payment_name.$txt_point).":".escape_output(getAmtPCustom($payment->amount)));
                        
                        if($ky<(sizeof($salePaymentDetails))-1){
                            $payment_details.=" - ";
                        }

                     endforeach;
                    endif;

                $sub_array[] = $payment_details;
                $sub_array[] = escape_output($value->full_name);
                $sub_array[] = '<div class="btn_group_wrap">
                                    '.$html.'
                                </div>';
                $data[] = $sub_array;
            endif;
        }
        $output = array(
            "draw" => intval($this->Sale_model->getDrawData()),
            "recordsTotal" => $this->Sale_model->get_all_data($outlet_id),
            "recordsFiltered" => $this->Sale_model->get_filtered_data($outlet_id),
            "data" => $data
        );
        echo json_encode($output);
    }
}
