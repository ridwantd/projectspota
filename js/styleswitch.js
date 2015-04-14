
function kopa_theme_option_reset_CLICK(){
    jQuery('input:radio[name="kopa-select-bg-choice"][value="pattern"]').prop('checked', true);  
   
    kopa_bg_CHANGE('pattern');    
    
    return false;
}

jQuery(document).ready(function($) {     
    kopa_style_switch_INIT();
    jQuery('.choose-color a.red').addClass('active');  
    jQuery('input:radio[name="kopa-select-bg-choice"][value="pattern"]').prop('checked', true);                    
});

function kopa_style_switch_INIT(){   
     
    // Color Change
    $("a.red" ).click(function(){
        $("#colors" ).attr("href", "css/colors/defaul.css");
        return false;
    });
		
    $("a.navy" ).click(function(){
        $("#colors" ).attr("href", "css/colors/navy.css");
        return false;
    });
		
    $("a.blue" ).click(function(){
        $("#colors" ).attr("href", "css/colors/blue.css");
        return false;
    });
		
    $("a.yellow" ).click(function(){
        $("#colors" ).attr("href", "css/colors/yellow.css");
        return false;
    });
		
    $("a.coban" ).click(function(){
        $("#colors" ).attr("href", "css/colors/coban.css");
        return false;
    });
	
	$("a.gray" ).click(function(){
        $("#colors" ).attr("href", "css/colors/gray.css");
        return false;
    });
		
    $('.choose-color a').click(function(e){
        e.preventDefault();
        $(this).parent().parent().find('a').removeClass('active');
        $(this).addClass('active');
    });
		
		
    
	
    // Switcher Layout
    $('#theme-option').animate({
        left: '-242px'
    });
		
    $('.open-close-button').click(function(e){
        e.preventDefault();
        var div = $('#theme-option');
        if (div.css('left') === '-242px') {
            $('#theme-option').animate({
                left: '0px'
            }); 
        } else {
            $('#theme-option').animate({
                left: '-242px'
            });
        }
    });
		

    // Reset
    $('a.reset').click(function(e){
        $('.color.red').trigger('click');
        jQuery('.theme-opt-wrapper select[name=layout]').val('pattern');	
        layout_CHANGE();
    });				    
}

function kopa_bg_CHANGE(val){
    if('pattern' == val){
        jQuery('body').removeClass('kopa-home-2');
    }else{
        jQuery('body').addClass('kopa-home-2');
    }
}

