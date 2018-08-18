$(function(){
	
	$(".b1").scrollable({
		size:6,
		items:".b1 ul",
		loop:true,
		prev:".arr_l",
		next:".arr_r"
	});

	var io=0;
	
	$(function(){
		$(".b1 li").click(function(){
			$(".bpic").empty();
			$(".bpic").fadeTo("medium", 0.5);
			$("div",this).clone().appendTo($(".bpic"));
			$(".bpic").fadeTo("medium", 1);
		});
		
		$(".b1 li:eq(0)").click();
		io=1;

		setInterval(function(){
			$(".b1 li:eq("+io+")").click();
			io++;
			if(io>=$(".b1 li").length){
				io=0	
			}
		},6000);
		
	});
	
	$(".b1 li").mousedown(function(){
		io=$(this).prevAll().length	+1
	});
	
})