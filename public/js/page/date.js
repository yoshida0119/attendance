// jQuery.noConflict();
$(function(){
	//デフォルトで５件表示
	for (var i = 0; i < 5; i++) {
		$('#clone' + String(i)).removeClass('d-none');
		$('.columCount').val(String(i));
	}

    //時：分のセレクトボックス生成
    $('.timepicker').timepicker({
        timeFormat: 'H:mm',
        interval: 30,
        minTime: '8',
        maxTime: '22:00',
        defaultTime: '10',
        startTime: '8:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });

    //デフォルト値が空
    $('.timepicker_edit').timepicker({
        timeFormat: 'H:mm',
        interval: 30,
        minTime: '8',
        maxTime: '22:00',
        defaultTime: '',
        startTime: '8:00',
        dynamic: true,
        dropdown: true,
        scrollbar: true
    });

	//日付
	$('.date_picker').datepicker();

	//追加ボタン押下時
	$('#addColumBtn').click(function(){
		//count取得　０スタート
		var count = parseInt($('.columCount').val()) + 1;
		//d-none
		$('#clone' + String(count)).removeClass('d-none');
		$('.columCount').val(String(count));
	});
});
