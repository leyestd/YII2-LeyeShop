/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    $("#myPics img").click(function () {
        var psrc = $(this).attr("src");
        $("#pic img").attr("src", psrc);
    });

    $("#MinusBt").click(function () {
        var count = parseInt($("#count").val());
        count--;
        if (count <= 0)
            count = 1;
        $("#count").val(count);
    });

    $("#PlusBt").click(function () {
        var count = parseInt($("#count").val());
        count++;
        var total = parseInt($("#total").data('total'));
        if (count > total)
            count = total;

        $("#count").val(count);
    });


    $("#quickbuy").click(function () {
        var count = parseInt($("#count").val());

        var total = parseInt($("#total").data('total'));
        if (count > total)
            count = total;

        var hreftext = $("#quickbuy").data('url');
        var seat = hreftext.indexOf("y=");
        var temphref = hreftext.substring(0, seat + 2);
        temphref += count;
        location.href = temphref;

    });

    $("#updateCart").click(function () {
        var url = $("#updateCart").data("url");
        var id = $("#updateCart").data("id");
        var count = parseInt($("#count").val());
        var total = parseInt($("#total").data('total'));

        if (count > total)
            count = total;
        if (count >= 1) {
            $.post(url, {'id': id, 'quantity': count}, function (json_data) {
                var data = $.parseJSON(json_data);
                $('#cartCount').text("购物车(" + data.count + ")");
                $("#addcart").fadeIn(100);
                $("#addcart").fadeOut(1000);
            });
        }
    });

    $("#moveDown").click(function () {

        var PicCount = $("#myPics").data('pics');
        var PicTotal = $("#myPics").data('pict');

        if (PicCount !== PicTotal) {
            $("#myPics").animate({"top": "+=140px"}, "fast");
            $("#myPics").data('pics', PicCount + 2);
        }
    });

    $("#moveUp").click(function () {
        var PicCount = $("#myPics").data('pics');
        if (PicCount > 4) {
            $("#myPics").animate({"top": "-=140px"}, "fast");
            $("#myPics").data('pics', PicCount - 2);
        }
    });

    $("#getcomment").click(function () {

        var url = $("#messages").data('url');
        var id = $("#messages").data('id');
        var number = $("#messages").data('number');
        var comment;
        var status = $("#messages").data('status');
        var tablebody = '<table class="table table-striped" style="margin-top:30px;font-size:16px;"><thead><tr><th>用户</th><th>评论</th><th style="width:80%">内容</th></tr></thead> <tbody></tbody></table>';
        tablebody += '<p style="text-align:right"><label style="margin-right:30px"><input type="radio" name="optionsRadios" id="r1" value="1">好评</label>';
        tablebody += '<label style="margin-right:30px"><input type="radio" name="optionsRadios" id="r2" value="2">中评</label>';
        tablebody += '<label style="margin-right:30px"><input type="radio" name="optionsRadios" id="r3" value="3">差评</label>';
        tablebody += '<button id="getmore" type="button" class="btn btn-success">查看更多.....</button></p>';

        if (number === 0) {
            $.getJSON(url, {'id': id, 'number': number}, function (json_data) {

                if (json_data !== null) {
                    if (status === 'nobody') {
                        $("#messages").empty();
                        $("#messages").append(tablebody);
                        $("#messages").data('status', 'ok');
                    }
                    $.each(json_data, function (name, value) {
                        var experience;
                        if (value.experience === "1") {
                            experience = '好评';
                        } else if (value.experience === "2") {
                            experience = '中评';
                        } else {
                            experience = "差评";
                        }
                        comment = "<tr><td>" + value.name + "</td>" + "<td>" + experience + "</td>" + "<td>" + value.comment + "</td></tr>";
                        $("#messages tbody").append(comment);
                        $("#messages").data('number', number + 8);
                    });
                }

            });
        }
    });

    $("#messages").on('click', 'button', function () {
        var url = $("#messages").data('url');
        var id = $("#messages").data('id');
        var number = $("#messages").data('number');
        var comment;
        var radioval = $("input[type='radio']:checked").val();

        if (radioval === null)
            radioval = 0;

        $.getJSON(url, {'id': id, 'number': number, 'experience': radioval}, function (json_data) {
            if (json_data !== null) {
                $.each(json_data, function (name, value) {
                    var experience;
                    
                    if (value.experience === "1") {
                        experience = '好评';
                    } else if (value.experience === "2") {
                        experience = '中评';
                    } else {
                        experience = "差评";
                    }
                    comment = "<tr><td>" + value.name + "</td>" + "<td>" + experience + "</td>" + "<td>" + value.comment + "</td></tr>";
                    $("#messages tbody").append(comment);
                    $("#messages").data('number', number + 8);
                });
            }

        });
    });

    $("#messages").on('click', "input", function () {
        var url = $("#messages").data('url');
        var id = $("#messages").data('id');

        var number = 0;
        var comment;

        var radioval = $("input[type='radio']:checked").val();

        var tablebody = '<table class="table table-striped" style="margin-top:30px;font-size:16px;"><thead><tr><th>用户</th><th>评论</th><th style="width:80%">内容</th></tr></thead> <tbody></tbody></table>';
        tablebody += '<p style="text-align:right"><label style="margin-right:30px"><input type="radio" name="optionsRadios" id="r1" value="1">好评</label>';
        tablebody += '<label style="margin-right:30px"><input type="radio" name="optionsRadios" id="r2" value="2">中评</label>';
        tablebody += '<label style="margin-right:30px"><input type="radio" name="optionsRadios" id="r3" value="3">差评</label>';
        tablebody += '<button id="getmore" type="button" class="btn btn-success">查看更多.....</button></p>';


        $.getJSON(url, {'id': id, 'number': number, 'experience': radioval}, function (json_data) {

            if (json_data !== null) {

                $("#messages").empty();
                $("#messages").append(tablebody);
                $("#messages").data('status', 'ok');

                $.each(json_data, function (name, value) {
                    var experience;
                    if (value.experience === "1") {
                        experience = '好评';
                    } else if (value.experience === "2") {
                        experience = '中评';
                    } else {
                        experience = "差评";
                    }
                    comment = "<tr><td>" + value.name + "</td>" + "<td>" + experience + "</td>" + "<td>" + value.comment + "</td></tr>";
                    $("#messages tbody").append(comment);

                    $("#r" + radioval).attr("checked", 'true');

                    $("#messages").data('number', number + 8);
                });
            } else {
                tablebody = '<p style="text-align:right"><label style="margin-right:30px"><input type="radio" name="optionsRadios" id="r1" value="1">好评</label>';
                tablebody += '<label style="margin-right:30px"><input type="radio" name="optionsRadios" id="r2" value="2">中评</label>';
                tablebody += '<label style="margin-right:30px"><input type="radio" name="optionsRadios" id="r3" value="3">差评</label></p>';
                $("#messages").empty();
                $("#messages").data('status', 'nobody');
                $("#messages").data('number', 0);
                $("#messages").append('<h2>没有用户发表评论！</h2>' + tablebody);
            }

        });



    });


    if (skuattr != null) {

        $('[data-order=0]').children('span').each(function () {
            
                
            var content=$(this).data('content');
            var hoverspan=$(this);
            var t=false;
            
            $.each(skuinfo, function (n, value) {

                t=false;
                if (value.split("-")[0] === content) {
                    t=true;
                    return false;  
                } 
            });
            if(t===true) {
                hoverspan.removeClass('notallow').addClass('mousehover');
                
            }

        });
        
        var proinfo=productSku.split('-');
        
        for(var i=0;i<proinfo.length;i++) {
            $('[data-order='+i+']').children('span').each(function(){
                
               var spanData=$(this).data("content");
               var spanCurrent=$(this);
               
               if(proinfo[i]===spanData) {
                   
                   $(this).addClass('select');
               }
               
               if(i>0) {
                   $.each(skuinfo, function (n, value) {
                       
                        strsplit=value.split("-");
                        var j;
                        for(j=0;j<i;j++) {
                            if(proinfo[j]!==strsplit[j]) {
                                return true;
                            }
                        }
                        if(strsplit[j]===spanData) {
                            spanCurrent.removeClass('notallow').addClass('mousehover');
                        }

                    });
                
               }
            });
        }

    }
    
    $(".skus").on("click", ".mousehover",(function() {
       $(this).siblings().removeClass('select');
       $(this).parent().nextAll().children('.select').removeClass('select');
       $(this).addClass('select');
       
       var parentOrder=$(this).parent().data('order')+1;
       var substr=[];
       
       $('.select').each(function () {
          substr.push($(this).data('content'));
       });
       
       if(skuattr.length>parentOrder) {
           
          $('[data-order='+parentOrder+']').children('span').each(function () {
                
            var content=$(this).data('content');
            var hoverspan=$(this);
            var t=false;
            
            $.each(skuinfo, function (n, value) {
          
                strsplit=value.split("-");
                
                for(var i=0;i<substr.length;i++) {
                    if(strsplit[i]!==substr[i]) {
                          
                        return true;
                    }
                }
                if (strsplit[parentOrder] === content) {
                   
                    t=true;
                    return false;  
                }
            });
            
            if(t===true) {
                hoverspan.removeClass('notallow').addClass('mousehover');
            }else {
                hoverspan.removeClass('mousehover').addClass('notallow');
            }
          });   
          
       }else if(substr.length===skuattr.length) {
       
           window.location.href=current+'&skuinfo='+substr.join('-');
       }
    }));

});