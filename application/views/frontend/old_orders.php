<?php
$company_info     = getMainCompany();
$categories       = getFoodMenuCategory();
$get_food_menu    = getFoodMenuForMenuPage();
$login_customer   = $this->session->userdata('customer_id');
$items_per_page   = 10;
$page             = $this->input->get('page') ?: 1;
$offset           = ($page - 1) * $items_per_page;
$old_orders       = getOrderHistory($login_customer, $items_per_page, $offset);
$total_orders     = getTotalOrders($login_customer);
$total_pages      = ceil($total_orders / $items_per_page);
$common_menu_page = isset($company_info->common_menu_page) && $company_info->common_menu_page ? json_decode($company_info->common_menu_page) : '';
$current_page = isset($_GET['page']) && $_GET['page']?$_GET['page']:0;
?>
 <!-- Sweet alert -->
 <script src="<?php echo base_url(); ?>assets/POS/sweetalert2/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/sweetalert2/dist/sweetalert.min.css">
<!-- Menu Wrapper Start -->
<div class="section old_order_section">
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="col-lg-10">
        <div class="card">
          <div class="card-header">
            <h4><?php echo lang('order_history'); ?></h4>
          </div>
          <div class="card-body">
            <table>
              <thead>
                <tr>
                  <th><?php echo lang('order_id'); ?></th>
                  <th><?php echo lang('date_time'); ?></th>
                  <th><?php echo lang('total'); ?></th>
                  <th><?php echo lang('status'); ?></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php if ($old_orders): 
                    $i = 1;
                    foreach ($old_orders as $order): 

                     $status_css = "";
                     $self_order_status = "";
                     if($order->self_order_status=="Approved"){
                         $status_css = 'approved';
                         $self_order_status = lang('approved');
                     }else if($order->self_order_status=="Pending"){
                        $status_css = 'pending';
                        $self_order_status = lang('pending');
                     }else if($order->self_order_status=="Decline"){
                        $status_css = 'decline';
                        $self_order_status = lang('decline');
                     }
                     if($order->is_invoice==1){
                        $status_css = 'approved';  ; 
                        $self_order_status = lang('invoice_generated');                     }

                    ?>
                    <tr>
                      <td><?php echo $order->sale_no; ?></td>
                      <td><?php echo $order->date_time; ?></td>
                      <td><?php echo getAmtCustom($order->total_payable); ?></td>
                      <td><span class="<?php echo $status_css?>"><?php echo $self_order_status; ?></span></td>
                      <td>      
                        <div class="display_none" id="order_details_<?php echo escape_output($i)?>"><?php echo ($order->self_order_content)?></div>                  
                        <a href="#" data-id="<?php echo escape_output($i)?>" class="btn2 re_order"><?php echo lang('re_order') ?></a>
                        <a href="<?php echo base_url('order-details/' . d($order->sale_no,1)); ?>" class="btn2"><?php echo lang('view_details') ?></a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5"><?php echo lang('no_order_found'); ?></td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
            <div class="pagination mt-50">
              <ul class="d-flex justify-content-center gap12px">                
                <li><a href="?page=<?php echo max(1, $current_page - 1); ?>" class="icon <?php echo $current_page == 1 ? 'disabled' : ''; ?>">
                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M13.3555 4.16665L7.52214 9.99998L13.3555 15.8333" stroke="#1A1A1A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </a></li>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                  <li><a href="?page=<?php echo $i; ?>" class="number <?php echo $i == $current_page ? 'active' : ''; ?>"><?php echo $i; ?></a></li>
                <?php endfor; ?>

                <li><a href="?page=<?php echo min($total_pages, $current_page + 1); ?>" class="icon <?php echo $current_page == $total_pages ? 'disabled' : ''; ?>">
                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M7.52148 4.16665L13.3548 9.99998L7.52148 15.8333" stroke="#1A1A1A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </a></li>
              </ul>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Menu Wrapper End -->