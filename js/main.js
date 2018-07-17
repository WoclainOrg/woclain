window.hilightBox = {};
window.hilightBoxBackground = {};
window.highlightClasses = [];
$(document).ready(function(){
	highlightClasses = getHilightClass();
	$("#reset").click(function(){
		  $.ajax({url:"/danma/api/clear.php",async:false});
		  window.location.reload();
	});
	$("#reload").click(function(){
		  window.location.reload();
	});
	
	$.getJSON("/danma/api/loadList.php",function(result){
		$domStr = "";
	    $.each(result, function(i, field){
	    	$domStr += "<div class='tip-dialog-list-item'><a href='#' rel='"+field["fn_url"]+"' onclick='openTipDetailDialog(this);'>"+field["fn"]+"</a></div>";
	    });
	    $("#tip-dialog-list").html($domStr);
	});
	
	$("#show").click(function(){
		  $("#tip-dialog-container").css("left",-310);
		  $("#tip-dialog-container").css("width",300);
		  $("#tip-dialog-container").css("height",410);
		  $("#tip-dialog-container").css("top",50);
		  $("#tip-dialog-container").show();
		  $("#tip-dialog-list").show();
		  
	});
	
	$("#tip-dialog-close").click(function(){
		  $("#tip-dialog-container").hide();
		  $("#tip-dialog-list-detail").hide();
		  $("#tip-dialog-list").hide();
		  
	});
	
	
	$("#hot").click(function(){
		
		defaultHilightClass();
		setHilightClass("hmax");
	});
	
	$("#cool").click(function(){
		
		defaultHilightClass();
		setHilightClass("hmin");
	});


	$("#warm").click(function(){
		defaultHilightClass();
		setHilightClass();
	});
	
	$("#default_hilight").click(function(){
		defaultHilightClass();
	});
	
	$(".hrow").each(function(index,obj){
		
		var mask = $("<div class='mask mask-row'></div>");
		mask.css("height",$(obj).height()+4);
		$(obj).append(mask);
		
		$(obj).click(function(){
			
			
			var me = this;
			var matchBall = $(this).parent().attr('class').match(/line\_\d+/i);
			
			if($(this).hasClass('hactive')){
				$(this).removeClass("hactive");
				$(this).find(".mask").css("display","none");
			}else{
				$(this).addClass("hactive");
				$(this).find(".mask").css("display","block");
			}
			
			
			if(matchBall != null){
				$("."+matchBall+" > div").each(function(i,_bdom){
					if($(me).hasClass('hactive') == false){
						$(_bdom).removeClass("hcol");
					}else{
						$(_bdom).addClass("hcol");
					}
				});
			}
			
			
			
			
		})
		
	})
	$(".sh-col").each(function(index,obj){
		$(obj).click(function(){
			var activeDom = $(this).parent().parent().parent();
			var contentDom = activeDom.find(".content-body > div");
			if($(this).hasClass('hactive')){
				$(this).removeClass("hactive");
				activeDom.css("width",'');
				contentDom.css("overflow","");
				contentDom.css("border-right","");
				$(this).parent().find(".mask[style*=block]").css("left","");
			}else{
				$(this).addClass("hactive");
				activeDom.css("width",30);
				contentDom.css("overflow","hidden");
				contentDom.css("border-right","solid #000 3px");
				$(this).parent().find(".mask[style*=block]").css("left","-10000px");
			}
			
		});
		
	})
	$(".qm_center_header").each(function(index,obj){
		
		var mask = $("<div class='mask mask-col'></div>");
		mask.css("height",$(obj).height()*$(".qm_center_header").length);
		mask.css("width",$(obj).width());
		$(obj).append(mask);
		
		
		$(obj).click(function(){
			var me = this;
			var matchBall = $(this).attr('class').match(/b\d{1}/i);
			var matchBallNum = null;

			
			if(matchBall != null){
				var headerMatchBall = $(".content-header ."+matchBall);
				headerMatchBall.each(function(i,hb){
					var hbDom = $(hb);
					if(hbDom.hasClass('hactive')){
						hbDom.removeClass("hactive");
						hbDom.find(".mask").css("display","none");
					}else{
						hbDom.addClass("hactive");
						hbDom.find(".mask").css("display","block");
					}
					
				});

				
				matchBallNum = matchBall[0].match(/\d{1}/)[0];
				if(matchBallNum != null){
					$("[rel="+matchBallNum+"]").each(function(i,_bdom){
						if($(me).hasClass('hactive') == false){
							$(_bdom).removeClass("hball");
						}else{
							$(_bdom).addClass("hball");
						}
						
					});
				}
			}
			
			
		});
		
		
	});
	
	
});
function getHilightClass(hType){
	var hClass = {};
	$(".qm").each(function(i,qmObj){
		var hlightClass = $(qmObj).attr('class').match(/hmax|hmin|h\d+/);
		var hlightBackgroud = $(qmObj).css('background-color');
		if(hlightClass != null){
			hilightBox[i] = hlightClass[0];
			if(hlightClass[0] != hType)
				hClass[hlightClass[0]] = null;
		}else{
			hilightBox[i] = hlightClass;
		}
		if(hlightBackgroud.match(/rgba.+/) == null){
			hilightBoxBackground[i] = null;
		}else{
			hilightBoxBackground[i] = hlightBackgroud;
		}
	});
	return hClass;
}

function defaultHilightClass(){
	$(".qm").each(function(i,qmObj){
		var hilightClass = hilightBox[i];
		var hilightBc = hilightBoxBackground[i];
		if(hilightClass != null){
			$(qmObj).addClass(hilightClass);
		}
		
		if(hilightBc != null){
			$(qmObj).css("background-color",hilightBc[i]);
		}
	});
}

function setHilightClass(hType){
	
	$(".qm").each(function(i,qmObj){
		var hilightClass = hilightBox[i];
		var hilightBc = hilightBoxBackground[i];
		if(hilightClass != null){
			if(hType == undefined){
				if(hilightClass == "hmax" || hilightClass == "hmin"){
					$(qmObj).removeClass(hilightClass);
					
				}
			}else{
				
				if(hilightClass != hType){
					$(qmObj).removeClass(hilightClass);
					
				}
			}
			
			
		}
		if(hType == undefined){
			if(hilightBc != null){
				$(qmObj).css("background-color",hilightBoxBackground[i]);
			}else{
				$(qmObj).css("background-color","");
			}
		}else{
			$(qmObj).css("background-color","");
		}
		
	});
}
function getHilightClassReg(hClass){
	// not used
	var hcs = Object.keys(hClass);
	if(hcs.length > 0)
		return hcs.join("|");
	return "";
}

function openTipDetailDialog(obj){
	var url = $(obj).attr("rel");
	var objDom = $("#tip-dialog-list-detail");
	
	var iframe = $("<iframe width='100%' height='100%' frameborder='no' marginheight='0' marginwidth='0' allowTransparency='true'></iframe>"); 
	var w = $(".main-content").width();
	var h = 
	objDom.html("");
	objDom.append(iframe);
	iframe.attr("src",url);
	$("#tip-dialog-container").css("top",-50);
	$("#tip-dialog-container").css("left",-($(".main-content").width()-70));
	$("#tip-dialog-container").css("width",$(".main-content").width());
	$("#tip-dialog-container").css("height",document.body.clientHeight-20);
	$("#tip-dialog-container").show();
	$("#tip-dialog-list-detail").show();
	$("#tip-dialog-list").hide();
	
}
