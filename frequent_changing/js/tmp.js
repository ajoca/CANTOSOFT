let current_count = parseInt(notification_div.text());
if(current_count===99 || current_count>99){
    notification_div.text("99+");
}else{
    notification_div.text(parseInt(notification_div.text()) + 1);
}
    