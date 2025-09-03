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
  # This is Report Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Report_model');
        $this->load->model('Inventory_model');
        $this->load->model('Sale_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();

        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }

        //start check access function
        $segment_2 = $this->uri->segment(2);
        $controller = "";
        $function = "";
        if($segment_2!="todayReport"){
            if($segment_2=="registerReport"){
                $controller = "159";
                $function = "view";
            }elseif($segment_2=="dailySummaryReport" || $segment_2=="printDailySummaryReport"){
                $controller = "161";
                $function = "view";
            }elseif($segment_2=="foodMenuSales"){
                $controller = "163";
                $function = "view";
            }elseif($segment_2=="saleReportByDate"){
                $controller = "165";
                $function = "view";
            }elseif($segment_2=="detailedSaleReport"){
                $controller = "167";
                $function = "view";
            }elseif($segment_2=="serviceDeliveryChargeReport"){
                $controller = "370";
                $function = "view";
            }elseif($segment_2=="consumptionReport"){
                $controller = "169";
                $function = "view";
            }elseif($segment_2=="inventoryReport"){
                $controller = "171";
                $function = "view";
            }elseif($segment_2=="getInventoryAlertList"){
                $controller = "173";
                $function = "view";
            }elseif($segment_2=="profitLossReport"){
                $controller = "175";
                $function = "view";
            }elseif($segment_2=="attendanceReport"){
                $controller = "179";
                $function = "view";
            }elseif($segment_2=="supplierLedgerReport"){
                $controller = "181";
                $function = "view";
            }elseif($segment_2=="supplierDueReport"){
                $controller = "183";
                $function = "view";
            }elseif($segment_2=="customerDueReport"){
                $controller = "185";
                $function = "view";
            }elseif($segment_2=="customerLedgerReport"){
                $controller = "187";
                $function = "view";
            }elseif($segment_2=="purchaseReportByDate"){
                $controller = "189";
                $function = "view";
            }elseif($segment_2=="expenseReport"){
                $controller = "191";
                $function = "view";
            }elseif($segment_2=="wasteReport"){
                $controller = "193";
                $function = "view";
            }elseif($segment_2=="vatReport"){
                $controller = "195";
                $function = "view";
            }elseif($segment_2=="foodMenuSaleByCategories"){
                $controller = "197";
                $function = "view";
            }elseif($segment_2=="tipsReport"){
                $controller = "199";
                $function = "view";
            }elseif($segment_2=="auditLogReport"){
                $controller = "201";
                $function = "view";
            }elseif($segment_2=="availableLoyaltyPointReport"){
                $controller = "205";
                $function = "view";
            }elseif($segment_2=="usageLoyaltyPointReport"){
                $controller = "203";
                $function = "view";
            }elseif($segment_2=="transferReport"){
                $controller = "307";
                $function = "view";
            }elseif($segment_2=="zReport"){
                $controller = "314";
                $function = "view";
            }elseif($segment_2=="productAnalysisReport"){
                $controller = "332";
                $function = "view";
            }elseif($segment_2=="productionReport"){
                $controller = "337";
                $function = "view";
            }elseif($segment_2=="kitchenPerformanceReport"){
                $controller = "362";
                $function = "view";
            }else{
                $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
                redirect('Authentication/userProfile');
            }

            if(!checkAccess($controller,$function)){
                $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
                redirect('Authentication/userProfile');
            }
        }

        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2', 'Please click on green Enter button of an outlet');
            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Outlet/outlets');
        }

        $login_session['active_menu_tmp'] = '';
        $this->session->set_userdata($login_session);
    }

      /**
     * print Daily Summary Report
     * @access public
     * @return void
     * @param string
     */
    public function printDailySummaryReport($selectedDate = '',$outlet_id){
        $data = array();
        $data['result'] = $this->Report_model->dailySummaryReport($selectedDate,$outlet_id);
        $data['selectedDate'] = $selectedDate;
        $data['outlet_id'] = $outlet_id;

        $this->load->view('report/printDailySummaryReport', $data);
    }
      /**
     * daily Summary Report
     * @access public
     * @return void
     * @param no
     */
    public function dailySummaryReport() {
        $data = array();
        /*This variable could not be escaped because this is an array field*/
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        if(!$outlet_id){
            $outlet_id = $this->session->userdata('outlet_id');
        }
        $data['outlet_id'] = $outlet_id;

        if (htmlspecialcharscustom($this->input->post('submit'))) {
            if ($this->input->post('date')) {
                $selectedDate = date("Y-m-d", strtotime($this->input->post('date')));
            } else {
                $selectedDate = '';
            }
            $data['result'] = $this->Report_model->dailySummaryReport($selectedDate,$outlet_id);
            $data['selectedDate'] = $selectedDate;

        } else {
            $selectedDate = date("Y-m-d");
            $data['result'] = $this->Report_model->dailySummaryReport($selectedDate,$outlet_id);
            $data['selectedDate'] = $selectedDate;
        }
        $data['main_content'] = $this->load->view('report/dailySummaryReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    public function zReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        if(!$outlet_id){
            $outlet_id = $this->session->userdata('outlet_id');
        }
        $data['outlet_id'] = $outlet_id;
        $selected_submit_post = $this->input->post('date');
        $selectedDate = (isset($selected_submit_post) && $selected_submit_post?$selected_submit_post:date("Y-m-d"));
        $data['sub_total_foods'] = $this->Report_model->sub_total_foods($selectedDate,$outlet_id);
        $data['sub_total_modifiers'] = $this->Report_model->sub_total_modifiers($selectedDate,$outlet_id);
        $data['totalDueReceived'] = $this->Report_model->totalDueReceived($selectedDate,$outlet_id);
        $data['service_charge_foods'] = $this->Report_model->delivery_charge_foods($selectedDate,$outlet_id,'service');
        $data['delivery_charge_foods'] = $this->Report_model->delivery_charge_foods($selectedDate,$outlet_id,'delivery');
        $data['waiter_tips_foods'] = $this->Report_model->waiter_tips_foods($selectedDate,$outlet_id);
        $data['taxes_foods'] = $this->Report_model->taxes_foods($selectedDate,$outlet_id);
        $data['total_discount_amount_foods'] = $this->Report_model->total_discount_amount_foods($selectedDate,$outlet_id);
        $data['total_due_amount_foods'] = $this->Report_model->total_due_amount_foods($selectedDate,$outlet_id);
        $data['totalFoodSales'] = $this->Report_model->totalFoodSales($selectedDate,$selectedDate,$outlet_id,"DESC");
        $data['totalFoodRefunds'] = $this->Report_model->totalFoodRefunds($selectedDate,$selectedDate,$outlet_id,"DESC");
        $data['totalFoodModifierSales'] = $this->Report_model->totalFoodModifierSales($selectedDate,$outlet_id,"DESC");
        $data['totals_sale_others'] = $this->Report_model->totalTaxDiscountChargeTips($selectedDate,$outlet_id);
        $data['totals_sale_service'] = $this->Report_model->totalCharge($selectedDate,$outlet_id,"service");
        $data['totals_sale_delivery'] = $this->Report_model->totalCharge($selectedDate,$outlet_id,"delivery");
        $data['get_all_sale_payment'] = $this->Report_model->getAllSalePaymentZReport($selectedDate,$outlet_id);
        $data['get_all_other_sale_payment'] = $this->Report_model->getAllOtherSalePaymentZReport($selectedDate,$outlet_id);
        $data['getAllPurchasePaymentZreport'] = $this->Report_model->getAllPurchasePaymentZreport($selectedDate,$outlet_id);
        $data['getAllExpensePaymentZreport'] = $this->Report_model->getAllExpensePaymentZreport($selectedDate,$outlet_id);
        $data['getAllSupplierPaymentZreport'] = $this->Report_model->getAllSupplierPaymentZreport($selectedDate,$outlet_id);
        $data['getAllCustomerDueReceiveZreport'] = $this->Report_model->getAllCustomerDueReceiveZreport($selectedDate,$outlet_id);


        $data['registers'] = getAllPaymentMethods('no');

        $array_p_name = array();

        foreach ($data['registers'] as $ky=>$vl){
            $data['registers'][$ky]->paid_sales = $this->Report_model->getAllSaleByPayment($selectedDate,$vl->id,$outlet_id);
            $data['registers'][$ky]->return_sales = $this->Report_model->getAllSaleReturnByPayment($selectedDate,$vl->id,$outlet_id);
            $data['registers'][$ky]->purchase = $this->Report_model->getAllPurchaseByPayment($selectedDate,$vl->id,$outlet_id);
            $data['registers'][$ky]->due_receive = $this->Report_model->getAllDueReceiveByPayment($selectedDate,$vl->id,$outlet_id);
            $data['registers'][$ky]->due_payment = $this->Report_model->getAllDuePaymentByPayment($selectedDate,$vl->id,$outlet_id);
            $data['registers'][$ky]->expense = $this->Report_model->getAllExpenseByPayment($selectedDate,$vl->id,$outlet_id);

            $inline_total = $data['registers'][$ky]->paid_sales - $data['registers'][$ky]->return_sales -  $data['registers'][$ky]->purchase + $data['registers'][$ky]->due_receive - $data['registers'][$ky]->due_payment - $data['registers'][$ky]->expense;
            $data['registers'][$ky]->inline_total = $inline_total;

            $array_p_name[] = $vl->name."||".$inline_total;
        }
        $data['total_payments'] = $array_p_name;
        $data['selectedDate'] = $selectedDate;
        $data['main_content'] = $this->load->view('report/zReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }
        /**
     * register Report
     * @access public
     * @return void
     * @param no
     */
    public function registerReport()
    {
        $data = array();

        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        if(!$outlet_id){
            $outlet_id = $this->session->userdata('outlet_id');
        }
        $data['outlet_id'] = $outlet_id;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $start_date = date("Y-m-d", strtotime($this->input->post('startDate')));
            $end_date = date("Y-m-d", strtotime($this->input->post('endDate')));
            if($start_date=="" || $end_date==""){
                $start_date = date('Y-m-d');
                $end_date = date('Y-m-d');
            }
            $user_id = $this->input->post('user_id');


            $data['register_info'] = $this->Report_model->getRegisterInformation($start_date,$end_date,$user_id,$outlet_id);
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['user_id'] = $user_id;
        }

        $company_id = $this->session->userdata('company_id');
        $data['users'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_users');
        $data['main_content'] = $this->load->view('report/registerReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * today Report
     * @access public
     * @return void
     * @param no
     */
    public function todayReport() {
        $data = array();
        $data['dailySummaryReport'] = $this->Report_model->todaySummaryReport('');
        echo json_encode($data['dailySummaryReport']);
    }
   
      /**
     * inventory Report
     * @access public
     * @return void
     * @param no
     */
    public function inventoryReport() {
        $data = array();
        $ingredient_id = $this->input->post('ingredient_id');
        $category_id = $this->input->post('category_id');
        $food_id = $this->input->post('food_id');
        $data['ingredient_id'] = $ingredient_id;
        $data['category_id'] = $category_id;
        $data['food_id'] = $food_id;

        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        if(!$outlet_id){
            $outlet_id = $this->session->userdata('outlet_id');
        }
        $data['outlet_id'] = $outlet_id;
        $company_id = $this->session->userdata('company_id');
        $data['ingredient_categories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_ingredient_categories");
        $data['ingredients'] = $this->Report_model->getInventory($category_id, $ingredient_id, $food_id,$outlet_id);
        $data['foodMenus'] = $this->Sale_model->getAllFoodMenus();
        $data['inventory'] = $this->Report_model->getInventory($category_id, $ingredient_id, $food_id,$outlet_id);

        $data['main_content'] = $this->load->view('report/inventoryReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * sale Report By Month
     * @access public
     * @return void
     * @param no
     */
    public function saleReportByMonth() {
        $data = array();
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startMonth')));
            $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endMonth')));
            $user_id =htmlspecialcharscustom($this->input->post($this->security->xss_clean('user_id')));
            $data['user_id'] = $user_id;
            if ($start_date && $end_date) {
                $start_date = date('Y-m', strtotime($this->input->post($this->security->xss_clean('startMonth'))));
                $start_date = $start_date . '-' . '01';
                $data['start_date'] = $start_date;
                $end_date = date('Y-m', strtotime($this->input->post($this->security->xss_clean('endMonth'))));
                $month = date('m', strtotime($this->input->post($this->security->xss_clean('endMonth'))));
                $finalDayByMonth = $this->Report_model->getLastDayInDateMonth($month);
                $end_date = $end_date . '-' . $finalDayByMonth;
                $data['end_date'] = $end_date;
            }
            if ($start_date && !$end_date) {
                $start_date = date('Y-m', strtotime($this->input->post($this->security->xss_clean('startMonth'))));
                $month = date('m', strtotime($this->input->post($this->security->xss_clean('startMonth'))));
                $finalDayByMonth = $this->Report_model->getLastDayInDateMonth($month);
                $temp = $start_date . '-' . $finalDayByMonth;
                $start_date = $start_date . '-' . '01';
                $end_date = $temp;
                $data['start_date'] = $start_date;
                $data['end_date'] = $temp;
            }
            if (!$start_date && $end_date) {
                $end_date = date('Y-m', strtotime($this->input->post($this->security->xss_clean('endMonth'))));
                $temp = $end_date . '-' . '01';
                $start_date = $temp;
                $month = date('m', strtotime($this->input->post($this->security->xss_clean('endMonth'))));
                $finalDayByMonth = $this->Report_model->getLastDayInDateMonth($month);
                $end_date = $end_date . '-' . $finalDayByMonth;
                $data['start_date'] = $temp;
                $data['end_date'] = $end_date;
            }
            $data['saleReportByMonth'] = $this->Report_model->saleReportByMonth($start_date, $end_date, $user_id);
        }


        $data['users'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_users');
        $data['main_content'] = $this->load->view('report/saleReportByMonth', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    public function vatReport()
    {
        $data = array();
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $outlet_id = isset($_POST['outlet_id']) && $_POST['outlet_id'] ? $_POST['outlet_id'] : '';
            if (!$outlet_id) {
                $outlet_id = $this->session->userdata('outlet_id');
            }
            $data['outlet_id'] = $outlet_id;
            $start_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $data['start_date'] = $start_date;
            $end_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $data['end_date'] = $end_date;
            $data['vatReport'] = $this->Report_model->vatReport($start_date, $end_date, $outlet_id);
        }
        $data['main_content'] = $this->load->view('report/vatReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * vat Report
     * @access public
     * @return void
     * @param no
     */
    public function tipsReport() {
        $data = array();
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
            if(!$outlet_id){
                $outlet_id = $this->session->userdata('outlet_id');
            }
            $waiter_id =htmlspecialcharscustom($this->input->post($this->security->xss_clean('waiter_id')));
            $data['waiter_id'] = $waiter_id;
            $data['outlet_id'] = $outlet_id;
            $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $data['start_date'] = $start_date;
            $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $data['end_date'] = $end_date;
            $data['tipsReport'] = $this->Report_model->tipsReport($start_date, $end_date,$outlet_id,$waiter_id);
        }
        $data['users'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_users');
        $data['main_content'] = $this->load->view('report/tipsReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * sale Report By Date
     * @access public
     * @return void
     * @param no
     */
    public function saleReportByDate() {
        $data = array();
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
            if(!$outlet_id){
                $outlet_id = $this->session->userdata('outlet_id');
            }
            $data['outlet_id'] = $outlet_id;
            $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $data['start_date'] = $start_date;
            $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $data['end_date'] = $end_date;
            $user_id =htmlspecialcharscustom($this->input->post($this->security->xss_clean('user_id')));
            $data['user_id'] = $user_id;
            $data['saleReportByDate'] = $this->Report_model->saleReportByDate($start_date, $end_date, $user_id,$outlet_id);
        }
        $data['users'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_users');
        $data['main_content'] = $this->load->view('report/saleReportByDate', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * profit Loss Report
     * @access public
     * @return void
     * @param no
     */
    public function profitLossReport() {
        $data = array();
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
            if(!$outlet_id){
                $outlet_id = $this->session->userdata('outlet_id');
            }
            $data['outlet_id'] = $outlet_id;
            $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            if ($start_date || $end_date) {
                $data['saleReportByDate'] = $this->Report_model->profitLossReport($start_date, $end_date,$outlet_id);
            }
        }
        $data['main_content'] = $this->load->view('report/profitLossReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    public function profitLossReportBackup() {
        $data = array();
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
            if(!$outlet_id){
                $outlet_id = $this->session->userdata('outlet_id');
            }
            $data['outlet_id'] = $outlet_id;
            $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            if ($start_date || $end_date) {
                $data['saleReportByDate'] = $this->Report_model->profitLossReportByDate($start_date, $end_date,$outlet_id);
                print("<Pre>");
                print_r($data['saleReportByDate']);exit;
            }
        }
        $data['main_content'] = $this->load->view('report/profitLossReportByDate', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * supplier ledger Report
     * @access public
     * @return void
     * @param no
     */
    public function supplierLedgerReport() {
        $company_id = $this->session->userdata('company_id');
        $data = array();


        if($this->input->post('submit')){
            $this->form_validation->set_rules('supplier_id', lang('supplier'), 'required|max_length[50]');
            if ($this->form_validation->run() == TRUE) {

                $start_date = date('Y-m-d',strtotime($this->input->post($this->security->xss_clean('startDate'))));
                $end_date = date('Y-m-d',strtotime($this->input->post($this->security->xss_clean('endDate'))));
                $supplier_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('supplier_id')));

                $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
                if(!$outlet_id){
                    $outlet_id = $this->session->userdata('outlet_id');
                }

                $data['supplier_id'] =$supplier_id;
                $data['outlet_id'] =$outlet_id;
                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                $remaining_due = $this->Report_model->getSupplierOpeningDueByDate($supplier_id,$start_date,$outlet_id);
                $key=0;
                $supplier = getSupplier($supplier_id);
                $op_start_date = date("Y-m-d",strtotime($supplier->added_date));;
                $op_end_date = date("Y-m-d",strtotime($start_date." -1days"));

                if($op_end_date<$op_start_date || $op_end_date==$op_start_date){
                    $op_date_view = date($this->session->userdata('date_format'), strtotime($op_start_date));
                }else{
                    $op_date_view = date($this->session->userdata('date_format'), strtotime($op_start_date))." - ".date($this->session->userdata('date_format'), strtotime($op_end_date));
                }

                $data['supplierLedger'][$key]['title']="Opening Due";
                $data['supplierLedger'][$key]['date']=$op_date_view;
                $data['supplierLedger'][$key]['grant_total']="N/A";

                $data['supplierLedger'][$key]['credit']="";

                $data['supplierLedger'][$key]['debit']=$remaining_due;
                $data['supplierLedger'][$key]['balance']=$remaining_due;
                $balance=-$remaining_due;

                //$balance=-$remaining_due;
                for($i=$start_date;$i<=$end_date;$i=date('Y-m-d',strtotime("+1 day",strtotime($i)))){
                    $purchase_grant_total=$this->Report_model->getSupplierGrantTotalByDate($supplier_id,$i,$outlet_id);
                    if(!empty($purchase_grant_total->total)){
                        $key++;
                        if($balance<0){
                            $balance=($balance+(-$purchase_grant_total->due));
                        }else{
                            $balance= ($balance-$purchase_grant_total->due);
                        }

                        $data['supplierLedger'][$key]['title']="Purchase Due Amount";
                        $data['supplierLedger'][$key]['date']=$i;
                        if($purchase_grant_total->due>0){
                            $data['supplierLedger'][$key]['grant_total']=$purchase_grant_total->total;
                            $data['supplierLedger'][$key]['debit']=$purchase_grant_total->due;
                        }else{
                            $data['supplierLedger'][$key]['grant_total']='';
                            $data['supplierLedger'][$key]['debit']='';
                        }
                        $data['supplierLedger'][$key]['credit']='';
                        $data['supplierLedger'][$key]['balance']=$balance;
                    }
                    $supplier_due_payment=$this->Report_model->getSupplierDuePaymentByDate($supplier_id,$i,$outlet_id);
                    if(!empty($supplier_due_payment)){
                        $key++;

                        $balance=$balance+$supplier_due_payment;

                        $data['supplierLedger'][$key]['title']="Supplier Due Payment";
                        $data['supplierLedger'][$key]['date']=$i;
                        $data['supplierLedger'][$key]['grant_total']="";
                        $data['supplierLedger'][$key]['debit']='';
                        $data['supplierLedger'][$key]['credit']=$supplier_due_payment;
                        if($balance!=0){
                            $data['supplierLedger'][$key]['balance']=$balance;
                        }else{
                            $data['supplierLedger'][$key]['balance']='';
                        }
                    }
                }
                $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_suppliers");
                $data['main_content'] = $this->load->view('report/supplierLedgerReport', $data, TRUE);
                $this->load->view('userHome', $data);
            }else{
                $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_suppliers");
                $data['main_content'] = $this->load->view('report/supplierLedgerReport', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }else{
            $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_suppliers");
            $data['main_content'] = $this->load->view('report/supplierLedgerReport', $data, TRUE);
            $this->load->view('userHome', $data);
        }

    }
      /**
     * customer Report
     * @access public
     * @return void
     * @param no
     */
    public function customerLedgerReport() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        if($this->input->post('submit')){
            $this->form_validation->set_rules('customer_id', lang('customer'), 'required|max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $start_date = date('Y-m-d',strtotime($this->input->post($this->security->xss_clean('startDate'))));
                $end_date = date('Y-m-d',strtotime($this->input->post($this->security->xss_clean('endDate'))));
                $customer_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
                $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
                if(!$outlet_id){
                    $outlet_id = $this->session->userdata('outlet_id');
                }
                $data['outlet_id'] =$outlet_id;
                $data['customer_id'] =$customer_id;
                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                $remaining_due = $this->Report_model->getCustomerOpeningDueByDate($customer_id,$start_date,$outlet_id);

                $customer = getCustomerData($customer_id);
                $op_start_date = date("Y-m-d",strtotime($customer->added_date));;
                $op_end_date = date("Y-m-d",strtotime($start_date." -1days"));

                if($op_end_date<$op_start_date || $op_end_date==$op_start_date){
                    $op_date_view = date($this->session->userdata('date_format'), strtotime($op_start_date));
                }else{
                    $op_date_view = date($this->session->userdata('date_format'), strtotime($op_start_date))." - ".date($this->session->userdata('date_format'), strtotime($op_end_date));
                }

                $key=0;
                $data['customerLedger'][$key]['title']="Opening Due";
                $data['customerLedger'][$key]['date']= $op_date_view;
                $data['customerLedger'][$key]['grant_total']="N/A";

                $data['customerLedger'][$key]['paid']="N/A";
                $data['customerLedger'][$key]['due']="N/A";

                $data['customerLedger'][$key]['credit']="N/A";
                $data['customerLedger'][$key]['debit']= getAmtP($remaining_due);
                $data['customerLedger'][$key]['balance']=getAmtP($remaining_due);
                $balance=$remaining_due;

                for($i=$start_date;$i<=$end_date;$i=date('Y-m-d',strtotime("+1 day",strtotime($i)))){
                    $sale_details=$this->Report_model->getCustomerGrantTotalByDate($customer_id,$i,$outlet_id);
                    if(!empty($sale_details->total)){
                        $key++;
                        $balance = ($balance+$sale_details->due);

                        $data['customerLedger'][$key]['title']="Sale Due Amount";
                        $data['customerLedger'][$key]['date']=$i;
                        $data['customerLedger'][$key]['grant_total']=getAmtP($sale_details->total);
                        $data['customerLedger'][$key]['paid']=getAmtP($sale_details->paid);
                        $data['customerLedger'][$key]['due']=getAmtP($sale_details->due);
                        $data['customerLedger'][$key]['debit']=getAmtP($sale_details->due);
                        $data['customerLedger'][$key]['credit']= getAmtP(0);
                        if($balance!=0){
                            $data['customerLedger'][$key]['balance']=getAmtP($balance);
                        }else{
                            $data['customerLedger'][$key]['balance']=getAmtP(0);
                        }
                    }
                    $payment_receive=$this->Report_model->getCustomerDuePaymentByDate($customer_id,$i,$outlet_id);
                    if(!empty($payment_receive)){
                        $key++;
                        $balance=$balance-$payment_receive;
                        $data['customerLedger'][$key]['title']="Due Receive";
                        $data['customerLedger'][$key]['date']=$i;
                        $data['customerLedger'][$key]['grant_total']=getAmtP($payment_receive);
                        $data['customerLedger'][$key]['paid']=getAmtP(0);
                        $data['customerLedger'][$key]['due']=getAmtP(0);
                        $data['customerLedger'][$key]['debit']= getAmtP(0);
                        $data['customerLedger'][$key]['credit']=getAmtP($payment_receive);
                        if($balance!=0){
                            $data['customerLedger'][$key]['balance']=getAmtP($balance);
                        }else{
                            $data['customerLedger'][$key]['balance']='';
                        }
                    }
                }
                $data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_customers");
                $data['main_content'] = $this->load->view('report/customerLedgerReport', $data, TRUE);
                $this->load->view('userHome', $data);
            }else{
                $data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_customers");
                $data['main_content'] = $this->load->view('report/customerLedgerReport', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }else{
            $data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_customers");
            $data['main_content'] = $this->load->view('report/customerLedgerReport', $data, TRUE);
            $this->load->view('userHome', $data);
        }

    }
      /**
     * customer Report
     * @access public
     * @return void
     * @param no
     */
    public function availableLoyaltyPointReport() {
        $data = array();
        $company_id = $this->session->userdata('company_id');

        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        if(!$outlet_id){
            $outlet_id = $this->session->userdata('outlet_id');
        }
        $customer_id =htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
        $data['customer_id'] = $customer_id;
        $data['outlet_id'] = $outlet_id;
        $data['customers'] = $this->Report_model->availableLoyaltyPointReport($customer_id,$outlet_id);
        $data['customers_dropdown'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customers');
        $data['main_content'] = $this->load->view('report/loyalty_point_available_report', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * customer Report
     * @access public
     * @return void
     * @param no
     */
    public function usageLoyaltyPointReport() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        if($this->input->post('submit')){
            $start_date = date('Y-m-d',strtotime($this->input->post($this->security->xss_clean('startDate'))));
            $end_date = date('Y-m-d',strtotime($this->input->post($this->security->xss_clean('endDate'))));
            $customer_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
            $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
            if(!$outlet_id){
                $outlet_id = $this->session->userdata('outlet_id');
            }
            $data['outlet_id'] =$outlet_id;
            $data['customer_id'] =$customer_id;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;

            $data = array();
            $company_id = $this->session->userdata('company_id');

            $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
            if(!$outlet_id){
                $outlet_id = $this->session->userdata('outlet_id');
            }
            $customer_id =htmlspecialcharscustom($this->input->post($this->security->xss_clean('customer_id')));
            $data['customer_id'] = $customer_id;
            $data['customers'] = $this->Report_model->usageLoyaltyPointReport($start_date, $end_date,$customer_id,$outlet_id);
            $data['customers_dropdown'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customers');
            $data['main_content'] = $this->load->view('report/loyalty_point_usage_report', $data, TRUE);
            $this->load->view('userHome', $data);
        }else{
            $data['customers_dropdown'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customers');
            $data['main_content'] = $this->load->view('report/loyalty_point_usage_report', $data, TRUE);
            $this->load->view('userHome', $data);
        }

    }
      /**
     * food Menu Sales
     * @access public
     * @return void
     * @param no
     */
    public function foodMenuSales() {
        $data = array();
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
            if(!$outlet_id){
                $outlet_id = $this->session->userdata('outlet_id');
            }
            $data['outlet_id'] = $outlet_id;
            $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $top_less =htmlspecialcharscustom($this->input->post($this->security->xss_clean('top_less')));
            $product_type =htmlspecialcharscustom($this->input->post($this->security->xss_clean('product_type')));
            $data['product_type'] = $product_type;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['outlet_id'] = $outlet_id;
            $data['top_less'] = $top_less;
            $data['foodMenuSales'] = $this->Report_model->foodMenuSales($start_date, $end_date,$outlet_id,$top_less,$product_type);
        }
        $data['main_content'] = $this->load->view('report/foodMenuSales', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    /**
     * food Menu Sales
     * @access public
     * @return void
     * @param no
     */
    public function foodMenuSaleByCategories() {
        $data = array();
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
            if(!$outlet_id){
                $outlet_id = $this->session->userdata('outlet_id');
            }
            $data['outlet_id'] = $outlet_id;
            $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $cat_id =htmlspecialcharscustom($this->input->post($this->security->xss_clean('cat_id')));
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['cat_id'] = $cat_id;
            $data['outlet_id'] = $outlet_id;
            $data['foodMenuSales'] = $this->Report_model->foodMenuSaleByCategories($start_date, $end_date,$outlet_id,$cat_id);
        }
        $company_id = $this->session->userdata('company_id');
        $data['foodMenuCategories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_food_menu_categories");
        $data['main_content'] = $this->load->view('report/foodMenuSaleByCategories', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    public function productAnalysisReport() {
        $data = array();
        $company_id = $this->session->userdata('company_id');
        $data['is_direct_food'] = '';
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('startDate', lang('start_date'), 'required|max_length[50]');
            $this->form_validation->set_rules('endDate', lang('end_date'), 'required|max_length[50]');
            $this->form_validation->set_rules('category_id', lang('category'), 'required|max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
                if(!$outlet_id){
                    $outlet_id = $this->session->userdata('outlet_id');
                }
                $data['outlet_id'] = $outlet_id;
                $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
                $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
                $category_id =htmlspecialcharscustom($this->input->post($this->security->xss_clean('category_id')));
                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                $data['category_id'] = $category_id;
                $data['outlet_id'] = $outlet_id;
                $total_qty_all = $this->Report_model->productAnalysisReportTotal($start_date, $end_date,$outlet_id,$category_id);
                $data['total_qty_all'] = 0;
                $data['total_amount_all'] = 0;
                $data['total_amount_all'] = 0;
                if(isset($total_qty_all) && $total_qty_all){
                    $data['total_qty_all'] = $total_qty_all->total_qty;
                    $data['total_amount_all'] = $total_qty_all->totalSale;
                }
                $data['productAnalysisReport'] = $this->Report_model->productAnalysisReport($start_date, $end_date,$outlet_id,$category_id);

                $data['categories'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_food_menu_categories");
                $data['main_content'] = $this->load->view('report/productAnalysisReport', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data['categories'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_food_menu_categories");
                $data['main_content'] = $this->load->view('report/productAnalysisReport', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }else{
            $data['categories'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_food_menu_categories");
            $data['main_content'] = $this->load->view('report/productAnalysisReport', $data, TRUE);
            $this->load->view('userHome', $data);
        }

    }
    /**
     * food Menu Sales
     * @access public
     * @return void
     * @param no
     */

    /**
     * food Menu Sales
     * @access public
     * @return void
     * @param no
     */
    public function foodMenuSaleDetailsByCategories() {
        $data = array();
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
            if(!$outlet_id){
                $outlet_id = $this->session->userdata('outlet_id');
            }
            $data['outlet_id'] = $outlet_id;
            $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $cat_id =htmlspecialcharscustom($this->input->post($this->security->xss_clean('cat_id')));
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['cat_id'] = $cat_id;
            $data['outlet_id'] = $outlet_id;
            $data['foodMenuSales'] = $this->Report_model->foodMenuSaleDetailsByCategories($start_date, $end_date,$outlet_id,$cat_id);
        }
        $company_id = $this->session->userdata('company_id');
        $data['foodMenuCategories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_food_menu_categories");
        $data['main_content'] = $this->load->view('report/foodMenuSaleDetailsByCategories', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * consumption Report
     * @access public
     * @return void
     * @param no
     */
    public function consumptionReport() {
        $data = array();
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
            if(!$outlet_id){
                $outlet_id = $this->session->userdata('outlet_id');
            }
            $data['outlet_id'] = $outlet_id;
            $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;

            $data['consumptionMenus'] = $this->Report_model->consumptionMenus($start_date, $end_date,$outlet_id);
            $data['consumptionModifiers'] = $this->Report_model->consumptionModifiers($start_date, $end_date,$outlet_id);
        }
        $data['main_content'] = $this->load->view('report/consumptionReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * detailed Sale Report
     * @access public
     * @return void
     * @param no
     */
    public function detailedSaleReport() {
        $data = array();
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
            if(!$outlet_id){
                $outlet_id = $this->session->userdata('outlet_id');
            }
            $data['outlet_id'] = $outlet_id;
            $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $user_id =htmlspecialcharscustom($this->input->post($this->security->xss_clean('user_id')));
            $waiter_id =htmlspecialcharscustom($this->input->post($this->security->xss_clean('waiter_id')));
            $data['user_id'] = $user_id;
            $data['waiter_id'] = $waiter_id;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['detailedSaleReport'] = $this->Report_model->detailedSaleReport($start_date, $end_date, $user_id,$outlet_id,$waiter_id);
        }
        $data['paymentMethods'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_payment_methods");
        $data['users'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_users');
        $data['main_content'] = $this->load->view('report/detailedSaleReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    public function serviceDeliveryChargeReport() {
        $data = array();
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
            if(!$outlet_id){
                $outlet_id = $this->session->userdata('outlet_id');
            }
            $data['outlet_id'] = $outlet_id;
            $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $charge_type =htmlspecialcharscustom($this->input->post($this->security->xss_clean('charge_type')));
            $waiter_id =htmlspecialcharscustom($this->input->post($this->security->xss_clean('waiter_id')));
            $data['charge_type'] = $charge_type;
            $data['waiter_id'] = $waiter_id;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['serviceDeliveryChargeReport'] = $this->Report_model->serviceDeliveryChargeReport($start_date, $end_date, $charge_type,$outlet_id,$waiter_id);
        }
        $data['paymentMethods'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_payment_methods");
        $data['users'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_users');
        $data['main_content'] = $this->load->view('report/serviceDeliveryChargeReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * purchase Report By Month
     * @access public
     * @return void
     * @param no
     */
    public function purchaseReportByMonth() {
        $data = array();
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startMonth')));
            $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endMonth')));
            $user_id =htmlspecialcharscustom($this->input->post($this->security->xss_clean('user_id')));
            $data['user_id'] = $user_id;
            if ($start_date && $end_date) {
                $start_date = date('Y-m', strtotime($this->input->post($this->security->xss_clean('startMonth'))));
                $start_date = $start_date . '-' . '01';
                $data['start_date'] = $start_date;
                $end_date = date('Y-m', strtotime($this->input->post($this->security->xss_clean('endMonth'))));
                $month = date('m', strtotime($this->input->post($this->security->xss_clean('endMonth'))));
                $finalDayByMonth = $this->Report_model->getLastDayInDateMonth($month);
                $end_date = $end_date . '-' . $finalDayByMonth;
                $data['end_date'] = $end_date;
            }
            if ($start_date && !$end_date) {
                $start_date = date('Y-m', strtotime($this->input->post($this->security->xss_clean('startMonth'))));
                $month = date('m', strtotime($this->input->post($this->security->xss_clean('startMonth'))));
                $finalDayByMonth = $this->Report_model->getLastDayInDateMonth($month);
                $temp = $start_date . '-' . $finalDayByMonth;
                $start_date = $start_date . '-' . '01';
                $end_date = $temp;
                $data['start_date'] = $start_date;
                $data['end_date'] = $temp;
            }
            if (!$start_date && $end_date) {
                $end_date = date('Y-m', strtotime($this->input->post($this->security->xss_clean('endMonth'))));
                $temp = $end_date . '-' . '01';
                $start_date = $temp;
                $month = date('m', strtotime($this->input->post($this->security->xss_clean('endMonth'))));
                $finalDayByMonth = $this->Report_model->getLastDayInDateMonth($month);
                $end_date = $end_date . '-' . $finalDayByMonth;
                $data['start_date'] = $temp;
                $data['end_date'] = $end_date;
            }
            $data['purchaseReportByMonth'] = $this->Report_model->purchaseReportByMonth($start_date, $end_date, $user_id);
        }


        $data['users'] = $this->Common_model->getAllByOutletIdForDropdown($company_id, 'tbl_users');
        $data['main_content'] = $this->load->view('report/purchaseReportByMonth', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * purchase Report By Date
     * @access public
     * @return void
     * @param no
     */
    public function purchaseReportByDate() {
        $data = array();
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
            if(!$outlet_id){
                $outlet_id = $this->session->userdata('outlet_id');
            }
            $data['outlet_id'] = $outlet_id;
            $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $data['start_date'] = $start_date;
            $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $data['end_date'] = $end_date;
            $data['purchaseReportByDate'] = $this->Report_model->purchaseReportByDate($start_date, $end_date,$outlet_id);
        }
        $data['main_content'] = $this->load->view('report/purchaseReportByDate', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * purchase Report By Ingredient
     * @access public
     * @return void
     * @param no
     */
    public function purchaseReportByIngredient() {
        $data = array();
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $ingredients_id =htmlspecialcharscustom($this->input->post($this->security->xss_clean('ingredients_id')));
            $data['ingredients_id'] = $ingredients_id;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['purchaseReportByIngredient'] = $this->Report_model->purchaseReportByIngredient($start_date, $end_date, $ingredients_id);
        }
        $data['ingredients'] = $this->Inventory_model->getAllByCompanyIdForDropdown($company_id, 'tbl_ingredients');
        $data['main_content'] = $this->load->view('report/purchaseReportByIngredient', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * detailed Purchase Report
     * @access public
     * @return void
     * @param no
     */
    public function detailedPurchaseReport() {
        $data = array();
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $user_id =htmlspecialcharscustom($this->input->post($this->security->xss_clean('user_id')));
            $data['user_id'] = $user_id;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['detailedPurchaseReport'] = $this->Report_model->detailedPurchaseReport($start_date, $end_date, $user_id);
        }
        $data['users'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_users');
        $data['main_content'] = $this->load->view('report/detailedPurchaseReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * waste Report
     * @access public
     * @return void
     * @param no
     */
    public function wasteReport() {
        $data = array();
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
            if(!$outlet_id){
                $outlet_id = $this->session->userdata('outlet_id');
            }
            $data['outlet_id'] = $outlet_id;
            $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $user_id =htmlspecialcharscustom($this->input->post($this->security->xss_clean('user_id')));
            $data['user_id'] = $user_id;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['wasteReport'] = $this->Report_model->wasteReport($start_date, $end_date, $user_id,$outlet_id);
        }
        $data['users'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_users');
        $data['main_content'] = $this->load->view('report/wasteReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * expense Report
     * @access public
     * @return void
     * @param no
     */
    public function expenseReport() {
        $data = array();
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
            if(!$outlet_id){
                $outlet_id = $this->session->userdata('outlet_id');
            }
            $data['outlet_id'] = $outlet_id;
            $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $expense_item_id =htmlspecialcharscustom($this->input->post($this->security->xss_clean('expense_item_id')));
            $data['expense_item_id'] = $expense_item_id;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['expenseReport'] = $this->Report_model->expenseReport($start_date, $end_date, $expense_item_id,$outlet_id);
        }
        $data['expense_items'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_expense_items');
        $data['main_content'] = $this->load->view('report/expenseReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * kitchen Performance Report
     * @access public
     * @return void
     * @param no
     */
    public function kitchenPerformanceReport() {
        $data = array();
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
            if(!$outlet_id){
                $outlet_id = $this->session->userdata('outlet_id');
            }
            $data['outlet_id'] = $outlet_id;
            $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['kitchenPerformanceReport'] = $this->Report_model->kitchenPerformanceReport($start_date, $end_date,$outlet_id);
        }
        $data['main_content'] = $this->load->view('report/kitchenPerformanceReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * supplier Due Report
     * @access public
     * @return void
     * @param no
     */
    public function supplierDueReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        if(!$outlet_id){
            $outlet_id = $this->session->userdata('outlet_id');
        }
        $data['outlet_id'] = $outlet_id;
        $data['supplierDueReport'] = $this->Report_model->supplierDueReport($outlet_id);
        $data['main_content'] = $this->load->view('report/supplierDueReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * customer Due Report
     * @access public
     * @return void
     * @param no
     */
    public function customerDueReport() {
        $data = array();
        $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        if(!$outlet_id){
            $outlet_id = $this->session->userdata('outlet_id');
        }
        $data['outlet_id'] = $outlet_id;
        $data['customers'] = $this->Report_model->customerDueReportNew($outlet_id);
        $data['main_content'] = $this->load->view('report/customerDueReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * get Inventory Alert List
     * @access public
     * @return void
     * @param no
     */
    public function getInventoryAlertList() {
        $data = array();
        $data['inventory'] = $this->Report_model->getInventoryAlertList();
        $data['main_content'] = $this->load->view('report/inventoryAlertList', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * attendance Report
     * @access public
     * @return void
     * @param no
     */
    public function attendanceReport() {
        $data = array();
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $employee_id =htmlspecialcharscustom($this->input->post($this->security->xss_clean('employee_id')));
            $data['employee_id'] = $employee_id;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['attendanceReport'] = $this->Report_model->attendanceReport($start_date, $end_date, $employee_id);
        }
        $company_id = $this->session->userdata('company_id');
        $data['employees'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_users");
        $data['main_content'] = $this->load->view('report/attendanceReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    public function auditLogReport()
    {
        $data = array();
        $data['submit_d'] = false;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            if($this->input->post('startDate')){
                $start_date = date("Y-m-d", strtotime($this->input->post('startDate')));
            }else{
                $start_date = '';
            }
            if($this->input->post('endDate')){
                $end_date = date("Y-m-d", strtotime($this->input->post('endDate')));
            }else{
                $end_date = '';
            }
            $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
            if(!$outlet_id){
                $outlet_id = $this->session->userdata('outlet_id');
            }

            $data['submit_d'] = true;
            $user_id = $this->input->post('user_id');
            $event_title = $this->input->post('event_title');
            $data['auditLogReport'] = $this->Report_model->auditLogReport($start_date,$end_date,$user_id,$event_title,$outlet_id);
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['user_id'] = $user_id;
            $data['event_title'] = $event_title;
        }
        $company_id = $this->session->userdata('company_id');
        $data['users'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_users');
        $data['main_content'] = $this->load->view('report/auditLogReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * transfer report
     * @access public
     * @return void
     * @param no
     */
    public function transferReport() {
        $data = array();
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $from_outlet_id  = isset($_POST['from_outlet_id']) && $_POST['from_outlet_id']?$_POST['from_outlet_id']:'';
            $to_outlet_id  = isset($_POST['to_outlet_id']) && $_POST['to_outlet_id']?$_POST['to_outlet_id']:'';

            $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['from_outlet_id'] = $from_outlet_id;
            $data['to_outlet_id'] = $to_outlet_id;
            $data['transferReport'] = $this->Report_model->transferReport($start_date, $end_date,$from_outlet_id,$to_outlet_id);
            foreach ($data['transferReport'] as $key=>$value){
                $foods = '';
                $food_list = $this->Common_model->getAllByCustomId($value->id,"transfer_id","tbl_transfer_ingredients",$order='');;
                foreach ($food_list as $keys=>$value1){
                    $foods.=getIngredientNameById($value1->ingredient_id)."(".getIngredientCodeById($value1->ingredient_id).") - ".$value1->quantity_amount." ".unitName(getPUnitIdByIgId($value1->ingredient_id));
                    if($keys>sizeof($food_list)-1){
                        $foods.="<br>";
                    }
                }
                $data['transferReport'][$key]->foods = $foods;
            }
        }
        $data['main_content'] = $this->load->view('report/transferReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    public function productionReport() {
        $data = array();
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $start_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('startDate')));
            $end_date =htmlspecialcharscustom($this->input->post($this->security->xss_clean('endDate')));
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['productionReport'] = $this->Report_model->productionReport($start_date, $end_date);
            foreach ($data['productionReport'] as $key=>$value){
                $foods = '';
                $food_list = $this->Common_model->getAllByCustomId($value->id,"production_id","tbl_production_ingredients",$order='');;
                foreach ($food_list as $keys=>$value1){
                    $foods.=getIngredientNameById($value1->ingredient_id)."(".getIngredientCodeById($value1->ingredient_id).") - ".$value1->quantity_amount." ".unitName(getUnitIdByIgId($value1->ingredient_id));
                    if($keys<sizeof($food_list)-1){
                        $foods.="<br>";
                    }
                }
                $data['productionReport'][$key]->foods = $foods;
            }
        }
        $outlet_id = $this->session->userdata('outlet_id');
        $data['kitchens'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_kitchens");
        $data['main_content'] = $this->load->view('report/productionReport', $data, TRUE);
        $this->load->view('userHome', $data);
    }

}
