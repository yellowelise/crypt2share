<?php

/** This file is part of KCFinder project
  *
  *      @desc File related functionality
  *   @package KCFinder
  *   @version 2.51
  *    @author Pavel Tzonkov <pavelc@users.sourceforge.net>
  * @copyright 2010, 2011 KCFinder Project
  *   @license http://www.opensource.org/licenses/gpl-2.0.php GPLv2
  *   @license http://www.opensource.org/licenses/lgpl-2.1.php LGPLv2
  *      @link http://kcfinder.sunhater.com
  */?>

browser.initFiles = function() {
	//alert('init');
    $(document).unbind('keydown');
    $(document).keydown(function(e) {
        return !browser.selectAll(e);
    });
    $('#files').unbind();
    $('#files').scroll(function() {
        browser.hideDialog();
    });
    $('.file').unbind();
    $('.file').click(function(e) {
        _.unselect();
        
        
       $('#mobile').css({visibility:'hidden'});
        browser.selectFile($(this), e);

    //    browser.menuFile($(this), e);
    });
    
    
    $('.file').rightClick(function(e) {
        _.unselect();
        browser.menuFile($(this), e);
        $('#mobile').css({visibility:'hidden'});
    });
    
    
    $('#files').rightClick(function(e) {
		browser.tastoDestro($(this), e);
		$('#mobile').css({visibility:'visible'});
		var left = e.pageX-80;
		var top = e.pageY+20;
		if (($('#mobile').outerWidth() + left) > $(window).width())
			left = $(window).width() - $('#mobile').outerWidth();
		if (($('#mobile').outerHeight() + top) > $(window).height())
			top = $(window).height() - $('#mobile').outerHeight();
		$('#mobile').css({
			left: left + 'px',
			top: top + 'px'
		});
		console.log(left + "x" + top);
		//alert("tasto destro");
    });
    
    $('.file').dblclick(function(e) {
        _.unselect();
        browser.menuFile($(this), e);
        $('#mobile').css({visibility:'hidden'});
    });
    $('.file').mouseup(function() {
        _.unselect();
    });
    $('.file').mouseout(function() {
        _.unselect();
    });
    $.each(this.shows, function(i, val) {
        var display = (_.kuki.get('show' + val) == 'off')
            ? 'none' : 'block';
        $('#files .file div.' + val).css('display', display);
        $('#files .pfile div.' + val).css('display', display);
    });
    this.statusDir();
   // load_img();
};

browser.showFiles = function(callBack, selected) {
    this.fadeFiles();
    setTimeout(function() {
        var html = '';
        var ii = 0;
        $.each(browser.files, function(i, file) {
			ii++;
            var stamp = [];
            $.each(file, function(key, val) {
                stamp[stamp.length] = key + "|" + val;
            });
            stamp = _.md5(stamp.join('|'));
            if (_.kuki.get('view') == 'list') {
                if (!i) html += '<table summary="list">';
                var icon = _.getFileExtension(file.name);
                if (file.thumb)
                    icon = '.image';
                else if (!icon.length || !file.smallIcon)
                    icon = '.';
                icon = 'themes/' + browser.theme + '/img/files/small/' + icon + '.png';
                html += '<tr class="file">' +
                    '<td class="name" style="background-image:url(' + icon + ')">' + _.htmlData(file.name) + '</td>' +
                    '<td class="time">' + file.date + '</td>' +
                    '<td class="size">' + browser.humanSize(file.size) + '</td>' +
                '</tr>';
                if (i == browser.files.length - 1) html += '</table>';
            } else {
                if (file.thumb)
                {
//                    var icon = browser.baseGetData('thumb') + '&file=' + encodeURIComponent(file.name) + '&dir=' + encodeURIComponent(browser.dir) + '&stamp=' + stamp;
					  var icon = encodeURIComponent(browser.dir + '/' +file.name);// + '&s=100&c=1';	
                      var mythumb = '<div class="thumb" style="line-height:100px;vertical-align:middle;" ><img id="thumb_' + ii + '" data-src="'+icon+'" data-ext="'+_.getFileExtension(file.name)+'" ></div>';
}
                else if (file.smallThumb) {
                    var icon = browser.uploadURL + '/' + browser.dir + '/' + file.name;
                    icon = _.escapeDirs(icon).replace(/\'/g, "%27");
                    var mythumb = '<div class="thumb" style="line-height:100px;vertical-align:middle;" ><img id="dfthumb_' + ii + '" src="'+icon+'" ></div>';
                } else {
                    var icon = file.bigIcon ? _.getFileExtension(file.name) : '.';
                    if (!icon.length) icon = '.';
                    icon = 'themes/' + browser.theme + '/img/files/big/' + icon + '.png';
                    var mythumb = '<div class="thumb" style="line-height:100px;vertical-align:middle;" ><img id="dfthumb_' + ii + '" src="'+icon+'" ></div>';
                }
                html += '<div class="file">' +
					mythumb +
                    '<div class="name">' + _.htmlData(file.name) + '</div>' +
                    '<div class="time">' + file.date + '</div>' +
                    '<div class="size">' + browser.humanSize(file.size) + '</div>' +
                '</div>';


        if (Math.floor((Math.random()*20)+1) < 5)
        {
			
		var quale = Math.floor((Math.random()*3)+1);
			
        if (quale == 1)
	     {
      		html += '<div class="pfile">' +
                    '<div style="width:100px;height:100px;"  class="thumb">'+
					'C2S è gratuito, ma un aiuto da parte vostra è auspicabile' +
					'<form target="_BLANK" method="post" action="https://www.paypal.com/cgi-bin/webscr">' +
					'<input type="hidden" value="_s-xclick" name="cmd">' +
					'<input type="hidden" value="HCAXDAALJCMBG" name="hosted_button_id">' +
					'<input type="image" border="0" alt="PayPal - Il metodo rapido, affidabile e innovativo per pagare e farsi pagare." name="submit" src="https://www.paypalobjects.com/it_IT/IT/i/btn/btn_donate_SM.gif">' +
					'<img width="1" height="1" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" alt="">' +
					'</form>' +                    
                    '</div>' +
                    '<div class="name" >&nbsp;</div>' +
                    '<div class="time">&nbsp;</div>' +
                    '<div class="size">&nbsp;</div>' +
                '</div>';

          }
        if (quale == 2)
	     {
			 
      		html += '<div class="pfile">' +
                    '<div style="width:100px;height:100px;"  class="thumb">'+
                    'C2S è gratis, donando una piccola somma ci darete un grande aiuto' +
					'<form target="_BLANK" method="post" action="https://www.paypal.com/cgi-bin/webscr">' +
					'<input type="hidden" value="_s-xclick" name="cmd">' +
					'<input type="hidden" value="HCAXDAALJCMBG" name="hosted_button_id">' +
					'<input type="image" border="0" alt="PayPal - Il metodo rapido, affidabile e innovativo per pagare e farsi pagare." name="submit" src="https://www.paypalobjects.com/it_IT/IT/i/btn/btn_donate_SM.gif">' +
					'<img width="1" height="1" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" alt="">' +
					'</form>' +                    
                    '</div>' +
                    '<div class="name" >&nbsp;</div>' +
                    '<div class="time">&nbsp;</div>' +
                    '<div class="size">&nbsp;</div>' +
                   '</div>';

		 }
        if (quale == 3)
        { 
        		html += '<div class="pfile">' +
                    '<div style="width:100px;height:100px;"  class="thumb">'+
                    'Sei soddisfatto di C2S? prendi in considerazione la donazione.' +
					'<form target="_BLANK" method="post" action="https://www.paypal.com/cgi-bin/webscr">' +
					'<input type="hidden" value="_s-xclick" name="cmd">' +
					'<input type="hidden" value="HCAXDAALJCMBG" name="hosted_button_id">' +
					'<input type="image" border="0" alt="PayPal - Il metodo rapido, affidabile e innovativo per pagare e farsi pagare." name="submit" src="https://www.paypalobjects.com/it_IT/IT/i/btn/btn_donate_SM.gif">' +
					'<img width="1" height="1" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" alt="">' +
					'</form>' +                    
                    '</div>' +                   
                    '<div class="name" >&nbsp;</div>' +
                    '<div class="time">&nbsp;</div>' +
                    '<div class="size">&nbsp;</div>' +
                '</div>';

		 }
		 
         } 
            }
             
        }
        );
        $('#files').html('<div>' + html + '</div>');
        $.each(browser.files, function(i, file) {
            var item = $('#files .file').get(i);
            $(item).data(file);
            if (_.inArray(file.name, selected) ||
                ((typeof selected != 'undefined') && !selected.push && (file.name == selected))
            )
                $(item).addClass('selected');
        });
        $('#files > div').css({opacity:'', filter:''});
        if (callBack) callBack();
         browser.initFiles();
         load_img();
    }, 200);
   
};

browser.selectFile = function(file, e) {
    if (e.ctrlKey || e.metaKey) {
		
        if (file.hasClass('selected'))
            file.removeClass('selected');
        else
            file.addClass('selected');
        var files = $('.file.selected').get();
        var size = 0;
        if (!files.length) {
            this.statusDir();
		}
        else {
			var data = file.data();
			
			
                $.each(files, function(i, cfile) {
                var cdata = $(cfile).data();
                var failed = false;
                for (i = 0; i < browser.clipboard.length; i++)
                    if ((browser.clipboard[i].name == cdata.name) &&
                        (browser.clipboard[i].dir == browser.dir)
                    ) {
                        failed = true
                        break;
                    }

                if (!failed) {
                    cdata.dir = browser.dir;
                    browser.clipboard[browser.clipboard.length] = cdata;
                }
            });
            browser.initClipboard();
			
            $.each(files, function(i, cfile) {
				//console.log(cfile);
				//console.log(data);
                size += parseInt($(cfile).data('size'));
            });
            size = this.humanSize(size);
            if (files.length > 1) {

                $('#fileinfo').html(files.length + ' ' + this.label("selected files") + ' (' + size + ')');

            } else {
                var data = $(files[0]).data();
                $('#fileinfo').html(data.name + ' (' + this.humanSize(data.size) + ', ' + data.date + ')');
            }
        }
    } else {
		 browser.clearClipboard();
        var data = file.data();
        $('.file').removeClass('selected');
        file.addClass('selected');
        browser.mobilemenuFile(file, e);
        //this.showMenu(e);
        //alert(e.pageX);
        if ((data.name.indexOf('.ogv')>-1) ||(data.name.indexOf('.mp4')>-1) || (data.name.indexOf('.flv')>-1))
         var play = "<button onclick=play_video('" + escape(browser.dir +'/'+ data.name)+"')><img src='themes/oxygen/img/icons/play.png'> Play Video</button>";
        else
          var play = ''; 
          
        $('#fileinfo').html(play+' <button onclick=moveto_secure(\'' + escape(browser.dir +'/'+ data.name)+'\') ><img src="../images/encrypt_ss.png"> Move to Secure</button>&nbsp;<button onclick=delete_file(\'' + escape(browser.dir +'/'+ data.name)+'\') ><img src="../images/delete.png"> Delete file</button>&nbsp;' + data.name + ' (' + this.humanSize(data.size) + ', ' + data.date + ')');
         //alert(navigator.userAgent);
         if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
               $('#mobile').css({visibility:'visible'});
           }
    }
};

browser.selectAll = function(e) {
    if ((!e.ctrlKey && !e.metaKey) || ((e.keyCode != 65) && (e.keyCode != 97)))
        return false;
    var files = $('.file').get();
    if (files.length) {
		//alert("all");
	
		
        var size = 0;
        $.each(files, function(i, file) {
            if (!$(file).hasClass('selected'))
                $(file).addClass('selected');
            size += parseInt($(file).data('size'));
        });
        size = this.humanSize(size);
        $('#fileinfo').html(files.length + ' ' + this.label("selected files") + ' (' + size + ')');
    }
    return true;
};

browser.returnFile = function(file) {

    var fileURL = file.substr
        ? file : browser.uploadURL + '/' + browser.dir + '/' + file.data('name');
    fileURL = _.escapeDirs(fileURL);

    if (this.opener.CKEditor) {
        this.opener.CKEditor.object.tools.callFunction(this.opener.CKEditor.funcNum, fileURL, '');
        window.close();

    } else if (this.opener.FCKeditor) {
        window.opener.SetUrl(fileURL) ;
        window.close() ;

    } else if (this.opener.TinyMCE) {
        var win = tinyMCEPopup.getWindowArg('window');
        win.document.getElementById(tinyMCEPopup.getWindowArg('input')).value = fileURL;
        if (win.getImageData) win.getImageData();
        if (typeof(win.ImageDialog) != "undefined") {
            if (win.ImageDialog.getImageData)
                win.ImageDialog.getImageData();
            if (win.ImageDialog.showPreviewImage)
                win.ImageDialog.showPreviewImage(fileURL);
        }
        tinyMCEPopup.close();

    } else if (this.opener.callBack) {

        if (window.opener && window.opener.KCFinder) {
            this.opener.callBack(fileURL);
            window.close();
        }

        if (window.parent && window.parent.KCFinder) {
            var button = $('#toolbar a[href="kcact:maximize"]');
            if (button.hasClass('selected'))
                this.maximize(button);
            this.opener.callBack(fileURL);
        }

    } else if (this.opener.callBackMultiple) {
        if (window.opener && window.opener.KCFinder) {
            this.opener.callBackMultiple([fileURL]);
            window.close();
        }

        if (window.parent && window.parent.KCFinder) {
            var button = $('#toolbar a[href="kcact:maximize"]');
            if (button.hasClass('selected'))
                this.maximize(button);
            this.opener.callBackMultiple([fileURL]);
        }

    }
};

browser.returnFiles = function(files) {
    if (this.opener.callBackMultiple && files.length) {
        var rfiles = [];
        $.each(files, function(i, file) {
            rfiles[i] = browser.uploadURL + '/' + browser.dir + '/' + $(file).data('name');
            rfiles[i] = _.escapeDirs(rfiles[i]);
        });
        this.opener.callBackMultiple(rfiles);
        if (window.opener) window.close()
    }
};

browser.returnThumbnails = function(files) {
    if (this.opener.callBackMultiple) {
        var rfiles = [];
        var j = 0;
        $.each(files, function(i, file) {
            if ($(file).data('thumb')) {
                rfiles[j] = browser.thumbsURL + '/' + browser.dir + '/' + $(file).data('name');
                rfiles[j] = _.escapeDirs(rfiles[j++]);
            }
        });
        this.opener.callBackMultiple(rfiles);
        if (window.opener) window.close()
    }
    
};

browser.tastoDestro = function(e) {
	
   // var data = file.data();
    var path = this.dir;
    var files = $('.file.selected').get();
    var html = '<div class="mobilemenu"><div class="menu">';

    html += 'Hai selezionato: ' + browser.clipboard.length + ' files<br />';
    if (browser.clipboard.length > 0)
    {
    html += '<a href="kcact:download">'+this.label("Download files")+'</a>' ;
    html += '<div class="delimiter"></div>' ;
    html += '<a href="kcact:cpcbd">'+this.label("Copy files here")+'</a>' ;
    html += '<a href="kcact:mvcbd">'+this.label("Move files here")+'</a>' ;
    html += '<a href="kcact:rmcbd">'+this.label("Delete files")+'</a>' ;
	}
   else
    {
		    html += '<div class="delimiter"></div>' ;
    html += 'Seleziona i files e copiali nella clipboard <br />(tasto destro > '+this.label("Copy to clipboard")+')' ;
	} 
    html += '</div></div>';



    
    
    $('#mobile').html(html);
    
        $('.menu a[href="kcact:download"]').click(function() {
            browser.hideDialog();
                        $("#mobile").css("visibility","hidden");

            browser.downloadClipboard();
            return false;
        });
        $('.menu a[href="kcact:cpcbd"]').click(function() {
            if (!browser.dirWritable) return false;
            browser.hideDialog();
            $("#mobile").css("visibility","hidden");
            browser.copyClipboard(browser.dir);
            return false;
        });
        $('.menu a[href="kcact:mvcbd"]').click(function() {
            if (!browser.dirWritable) return false;
            browser.hideDialog();
            $("#mobile").css("visibility","hidden");
            browser.moveClipboard(browser.dir);
            return false;
        });
        $('.menu a[href="kcact:rmcbd"]').click(function() {
            browser.hideDialog();
            $("#mobile").css("visibility","hidden");
            browser.confirm(
                browser.label("Are you sure you want to delete all files in the Clipboard?"),
                function(callBack) {
                    if (callBack) callBack();
                    browser.deleteClipboard();
                }
            );
            return false;
        });    
};

browser.mobilemenuFile = function(file, e) {
    var data = file.data();
    var path = this.dir + '/' + data.name;
    var files = $('.file.selected').get();
    var html = '';

        html += '<div class="mobilemenu"><div class="menu">';
        $('.file').removeClass('selected');
        file.addClass('selected');
        $('#fileinfo').html(data.name + ' (' + this.humanSize(data.size) + ', ' + data.date + ')');
        
            html +='<label>' + data.name + '</label>';
        
        if (data.thumb || data.smallThumb)
            html +='<a  href="kcact:view">' + this.label("View") + '</a>';

        html +=
            '<a href="kcact:download">' + this.label("Download") + '</a>';

        if (this.access.files.copy || this.access.files.move)
            html += '<div class="delimiter"></div>' +
                '<a href="kcact:clpbrdadd">' + this.label("Copy to Clipboard") + '</a>';
        if (this.access.files.rename || this.access.files['delete'])
            html += '<div class="delimiter"></div>';
        if (this.access.files.rename)
            html += '<a href="kcact:mv"' + (!data.writable ? ' class="denied"' : '') + '>' +
                this.label("Rename...") + '</a>';
        if (this.access.files['delete'])
            html += '<a href="kcact:rm"' + (!data.writable ? ' class="denied"' : '') + '>' +
                this.label("Delete") + '</a>';

            html += '<div class="delimiter"></div>';


        if ((data.name.indexOf('.htm')>-1)||(data.name.indexOf('.html')>-1)||(data.name.indexOf('.shtml')>-1))
        html +=
            '<a href="kcact:textedit">' + this.label("Modifica file") + '</a>';

        if ((data.name.indexOf('.ogv')>-1) ||(data.name.indexOf('.mp4')>-1) || (data.name.indexOf('.flv')>-1))
        html +=
            '<a href="kcact:play">' + this.label("Riproduci Video") + '</a>';

        if ((data.name.indexOf('.mp3')>-1))
        html +=
            '<a href="kcact:play_mp3">' + this.label("Riproduci MP3") + '</a>';


        html +=
            '<a href="kcact:crypt">' + this.label("Cripta") + '</a>';
        html +=
            '<a href="kcact:copyfriends">' + this.label("Copia in Amico") + '</a>';

        html += '</div></div>';


    
    
    $('#mobile').html(html);
    
    var left = e.pageX-80;
    var top = e.pageY+20;
    if (($('#mobile').outerWidth() + left) > $(window).width())
        left = $(window).width() - $('#mobile').outerWidth();
    if (($('#mobile').outerHeight() + top) > $(window).height())
        top = $(window).height() - $('#mobile').outerHeight();
    $('#mobile').css({
        left: left + 'px',
        top: top + 'px',
        display: 'none'
    });

    $('#mobile').fadeIn();    
 //   alert(data.name);
         $('.mobilemenu a[href="kcact:download"]').click(function() {
            var html = '<form id="downloadForm" method="post" action="' + browser.baseGetData('download') + '">' +
                '<input type="hidden" name="dir" />' +
                '<input type="hidden" name="file" />' +
            '</form>';
            $('#dialog').html(html);
            $('#downloadForm input').get(0).value = browser.dir;
            $('#downloadForm input').get(1).value = data.name;
            $('#downloadForm').submit();
            return false;
        });
        $('.mobilemenu a[href="kcact:crypt"]').click(function() {
                moveto_secure(browser.dir +"/" + data.name);	
             return false;
           });
        $('.mobilemenu a[href="kcact:copyfriends"]').click(function() {
                copy_to_friend(browser.dir +"/" + data.name);	
              return false;
           });
        $('.mobilemenu a[href="kcact:edittext"]').click(function() {
			  //alert(browser.dir +'/'+ data.name);
             text_edit(escape(browser.dir +'/'+ data.name));
             return false;
           });
        $('.mobilemenu a[href="kcact:play"]').click(function() {
			//alert(browser.dir +'/'+ data.name);
             play_video(escape(browser.dir +'/'+ data.name));
             return false;
           });
        $('.mobilemenu a[href="kcact:play_mp3"]').click(function() {
			//alert(browser.dir +'/'+ data.name);
             play_mp3(escape(browser.dir +'/'+ data.name));
             return false;
           });


        $('.mobilemenu a[href="kcact:clpbrdadd"]').click(function() {
            for (i = 0; i < browser.clipboard.length; i++)
                if ((browser.clipboard[i].name == data.name) &&
                    (browser.clipboard[i].dir == browser.dir)
                ) {
                    browser.hideDialog();
                    browser.alert(browser.label("This file is already added to the Clipboard."));
                    return false;
                }
            var cdata = data;
            cdata.dir = browser.dir;
            browser.clipboard[browser.clipboard.length] = cdata;
            browser.initClipboard();
            browser.hideDialog();
            return false;
        });

        $('.mobilemenu a[href="kcact:mv"]').click(function(e) {
            if (!data.writable) return false;
            browser.fileNameDialog(
                e, {dir: browser.dir, file: data.name},
                'newName', data.name, browser.baseGetData('rename'), {
                    title: "New file name:",
                    errEmpty: "Please enter new file name.",
                    errSlash: "Unallowable characters in file name.",
                    errDot: "File name shouldn't begins with '.'"
                },
                function() {
                    browser.refresh();
                }
            );
            return false;
        });

        $('.mobilemenu a[href="kcact:rm"]').click(function() {
            if (!data.writable) return false;
            browser.hideDialog();
            browser.confirm(browser.label("Are you sure you want to delete this file?"),
                function(callBack) {
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: browser.baseGetData('delete'),
                        data: {dir:browser.dir, file:data.name},
                        async: false,
                        success: function(data) {
                            if (callBack) callBack();
                            browser.clearClipboard();
                            if (browser.check4errors(data))
                                return;
                            browser.refresh();
                        },
                        error: function() {
                            if (callBack) callBack();
                            browser.alert(browser.label("Unknown error."));
                        }
                    });
                }
            );
            return false;
        });
        
        $('.mobilemenu a[href="kcact:view"]').click(function() {
                show_gallery(browser.dir, data.name);	
                return false;
           });
           
     $('.mobilemenu a[href="_kcact:view"]').click(function() {
        browser.hideDialog();
        var ts = new Date().getTime();
        var showImage = function(data) {
            url = _.escapeDirs(browser.uploadURL + '/' + browser.dir + '/' + data.name) + '?ts=' + ts,
            $('#loading').html(browser.label("Loading image..."));
            $('#loading').css('display', 'inline');
            var img = new Image();
            img.src = url;
            img.onerror = function() {
                browser.lock = false;
                $('#loading').css('display', 'none');
                browser.alert(browser.label("Unknown error."));
                $(document).unbind('keydown');
                $(document).keydown(function(e) {
                    return !browser.selectAll(e);
                });
                browser.refresh();
            };
            var onImgLoad = function() {
                browser.lock = false;
                $('#files .file').each(function() {
                    if ($(this).data('name') == data.name)
                        browser.ssImage = this;
                });
                $('#loading').css('display', 'none');
                $('#dialog').html('<div class="slideshow"><img /></div>');
                $('#dialog img').attr({
                    src: url,
                    title: data.name
                }).fadeIn('fast', function() {
                    var o_w = $('#dialog').outerWidth();
                    var o_h = $('#dialog').outerHeight();
                    var f_w = $(window).width() - 30;
                    var f_h = $(window).height() - 30;
                    if ((o_w > f_w) || (o_h > f_h)) {
                        if ((f_w / f_h) > (o_w / o_h))
                            f_w = parseInt((o_w * f_h) / o_h);
                        else if ((f_w / f_h) < (o_w / o_h))
                            f_h = parseInt((o_h * f_w) / o_w);
                        $('#dialog img').attr({
                            width: f_w,
                            height: f_h
                        });
                    }
                    $('#dialog').unbind('click');
                    $('#dialog').click(function(e) {
                        browser.hideDialog();
                        $(document).unbind('keydown');
                        $(document).keydown(function(e) {
                            return !browser.selectAll(e);
                        });
                        if (browser.ssImage) {
                            browser.selectFile($(browser.ssImage), e);
                        }
                    });
                    browser.showDialog();
                    var images = [];
                    $.each(browser.files, function(i, file) {
                        if (file.thumb || file.smallThumb)
                            images[images.length] = file;
                    });
                    if (images.length)
                        $.each(images, function(i, image) {
                            if (image.name == data.name) {
                                $(document).unbind('keydown');
                                $(document).keydown(function(e) {
                                    if (images.length > 1) {
                                        if (!browser.lock && (e.keyCode == 37)) {
                                            var nimg = i
                                                ? images[i - 1]
                                                : images[images.length - 1];
                                            browser.lock = true;
                                            showImage(nimg);
                                        }
                                        if (!browser.lock && (e.keyCode == 39)) {
                                            var nimg = (i >= images.length - 1)
                                                ? images[0]
                                                : images[i + 1];
                                            browser.lock = true;
                                            showImage(nimg);
                                        }
                                    }
                                    if (e.keyCode == 27) {
                                        browser.hideDialog();
                                        $(document).unbind('keydown');
                                        $(document).keydown(function(e) {
                                            return !browser.selectAll(e);
                                        });
                                    }
                                });
                            }
                        });
                });
            };
            if (img.complete)
                onImgLoad();
            else
                img.onload = onImgLoad;
        };
        showImage(data);
        return false;
    });    
    

 
}


browser.menuFile = function(file, e) {
    var data = file.data();
    var path = this.dir + '/' + data.name;
    var files = $('.file.selected').get();
    var html = '';

    if (file.hasClass('selected') && files.length && (files.length > 1)) {
		//alert("qui");
        var thumb = false;
        var notWritable = 0;
        var cdata;
        $.each(files, function(i, cfile) {
            cdata = $(cfile).data();
            if (cdata.thumb) thumb = true;
            if (!data.writable) notWritable++;
        });
        if (this.opener.callBackMultiple) {
            html += '<a href="kcact:pick">' + this.label("Select") + '</a>';
            if (thumb) html +=
                '<a href="kcact:pick_thumb">' + this.label("Select Thumbnails") + '</a>';
        }
        if (data.thumb || data.smallThumb || this.support.zip) {
            html += (html.length ? '<div class="delimiter"></div>' : '');
            if (data.thumb || data.smallThumb)
                html +='<a href="kcact:view">' + this.label("View") + '</a>';
            if (this.support.zip) html += (html.length ? '<div class="delimiter"></div>' : '') +
                '<a href="kcact:download">' + this.label("Download") + '</a>';
        }

        if (this.access.files.copy || this.access.files.move)
            html += '<a href="kcact:selectall">' + this.label("Select all") + '</a>';
        if (this.access.files.copy || this.access.files.move)
            html += (html.length ? '<div class="delimiter"></div>' : '') +
                '<a href="kcact:clpbrdadd">' + this.label("Add to Clipboard") + '</a>';
        if (this.access.files['delete'])
            html += (html.length ? '<div class="delimiter"></div>' : '') +
                '<a href="kcact:rm"' + ((notWritable == files.length) ? ' class="denied"' : '') +
                '>' + this.label("Delete") + '</a>';
         
         html +=
            '<a href="kcact:crypt">' + this.label("Cripta") + '</a>';
         html +=
            '<a href="kcact:copyfriends">' + this.label("Copia in amico") + '</a>';
         html +=
            '<a href="kcact:copymysite">' + this.label("Copia in MySite") + '</a>';


        if (html.length) {
            html = '<div class="menu">' + html + '</div>';
            $('#dialog').html(html);
            this.showMenu(e);
        } else
            return;

        $('.menu a[href="kcact:pick"]').click(function() {
            browser.returnFiles(files);
            browser.hideDialog();
            return false;
        });

        $('.menu a[href="kcact:selectall"]').click(function() {
			browser.hideDialog();
            select_all();
            console.log("select all 793");
            
            $.each(files, function(i, file) {
            if ($(file).hasClass('selected'))
				{
					console.log(file);
				}
			});
            
          
		
            return false;
        });

        $('.menu a[href="kcact:pick_thumb"]').click(function() {
            browser.returnThumbnails(files);
            browser.hideDialog();
            return false;
        });

        $('.menu a[href="kcact:download"]').click(function() {
            browser.hideDialog();
            var pfiles = [];
            $.each(files, function(i, cfile) {
                pfiles[i] = $(cfile).data('name');
            });
            browser.post(browser.baseGetData('downloadSelected'), {dir:browser.dir, files:pfiles});
            return false;
        });


        $('.menu a[href="kcact:crypt"]').click(function() {
            browser.hideDialog();
            var pfiles = [];
            $.each(files, function(i, cfile) {
               pfiles[i] = $(cfile).data('name');
            });
            
            
             moveto_secure_m(browser.dir,pfiles);	
            //browser.post(browser.baseGetData('downloadSelected'), {dir:browser.dir, files:pfiles});
            return false;
        });        

        $('.menu a[href="kcact:copymysite"]').click(function() {
            browser.hideDialog();
            var pfiles = [];
            $.each(files, function(i, cfile) {
               pfiles[i] = $(cfile).data('name');
            });
            
            
             copy_to_mysite_m(browser.dir,pfiles);	
            //browser.post(browser.baseGetData('downloadSelected'), {dir:browser.dir, files:pfiles});
            return false;
        });        


        $('.menu a[href="kcact:copyfriends"]').click(function() {
            browser.hideDialog();
            var pfiles = [];
            $.each(files, function(i, cfile) {
               pfiles[i] = $(cfile).data('name');
            });
            
             copy_to_friend_m(browser.dir,pfiles);
             //moveto_secure_m(browser.dir,pfiles);	
            //browser.post(browser.baseGetData('downloadSelected'), {dir:browser.dir, files:pfiles});
            return false;
        });        


        $('.menu a[href="kcact:clpbrdadd"]').click(function() {
            browser.hideDialog();
            var msg = '';
            $.each(files, function(i, cfile) {
                var cdata = $(cfile).data();
                var failed = false;
                for (i = 0; i < browser.clipboard.length; i++)
                    if ((browser.clipboard[i].name == cdata.name) &&
                        (browser.clipboard[i].dir == browser.dir)
                    ) {
                        failed = true
                        msg += cdata.name + ": " + browser.label("This file is already added to the Clipboard.") + "\n";
                        break;
                    }

                if (!failed) {
                    cdata.dir = browser.dir;
                    browser.clipboard[browser.clipboard.length] = cdata;
                }
            });
            browser.initClipboard();
            if (msg.length) browser.alert(msg.substr(0, msg.length - 1));
            return false;
        });

        $('.menu a[href="kcact:rm"]').click(function() {
            if ($(this).hasClass('denied')) return false;
            browser.hideDialog();
            var failed = 0;
            var dfiles = [];
            $.each(files, function(i, cfile) {
                var cdata = $(cfile).data();
                if (!cdata.writable)
                    failed++;
                else
                    dfiles[dfiles.length] = browser.dir + "/" + cdata.name;
            });
            if (failed == files.length) {
                browser.alert(browser.label("The selected files are not removable."));
                return false;
            }

            var go = function(callBack) {
                browser.fadeFiles();
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: browser.baseGetData('rm_cbd'),
                    data: {files:dfiles},
                    async: false,
                    success: function(data) {
                        if (callBack) callBack();
                        browser.check4errors(data);
                        browser.refresh();
                    },
                    error: function() {
                        if (callBack) callBack();
                        $('#files > div').css({
                            opacity: '',
                            filter: ''
                        });
                        browser.alert(browser.label("Unknown error."));
                    }
                });
            };

            if (failed)
                browser.confirm(
                    browser.label("{count} selected files are not removable. Do you want to delete the rest?", {count:failed}),
                    go
                )

            else
                browser.confirm(
                    browser.label("Are you sure you want to delete all selected files?"),
                    go
                );

            return false;
        });

    } else {
    //	alert(data.name);
        
        html += '<div class="menu">';
        $('.file').removeClass('selected');
        file.addClass('selected');
        $('#fileinfo').html(data.name + ' (' + this.humanSize(data.size) + ', ' + data.date + ')');
        if (this.opener.callBack || this.opener.callBackMultiple) {
            html += '<a href="kcact:pick">' + this.label("Select") + '</a>';
            if (data.thumb) html +=
                '<a href="kcact:pick_thumb">' + this.label("Select Thumbnail") + '</a>';
            html += '<div class="delimiter"></div>';
        }

        if (data.thumb || data.smallThumb)
            html +='<a href="kcact:view">' + this.label("View") + '</a>';

        html +=
            '<a href="kcact:download">' + this.label("Download") + '</a>';
        if (this.access.files.copy || this.access.files.move)
            html += '<a href="kcact:selectall">' + this.label("Select all") + '</a>';
        if (this.access.files.copy || this.access.files.move)
            html += '<div class="delimiter"></div>' +
                '<a href="kcact:clpbrdadd">' + this.label("Add to Clipboard") + '</a>';
        if (this.access.files.rename || this.access.files['delete'])
            html += '<div class="delimiter"></div>';
        if (this.access.files.rename)
            html += '<a href="kcact:mv"' + (!data.writable ? ' class="denied"' : '') + '>' +
                this.label("Rename...") + '</a>';
        if (this.access.files['delete'])
            html += '<a href="kcact:rm"' + (!data.writable ? ' class="denied"' : '') + '>' +
                this.label("Delete") + '</a>';

        html += '<div class="delimiter"></div>';
        
        if ((data.name.indexOf('.htm')>-1)||(data.name.indexOf('.html')>-1)||(data.name.indexOf('.shtml')>-1))
        html +=
            '<a href="kcact:edittext">' + this.label("Modifica file") + '</a>';
        
        if ((data.name.indexOf('.ogv')>-1) ||(data.name.indexOf('.mp4')>-1) || (data.name.indexOf('.flv')>-1))
        html +=
            '<a href="kcact:play">' + this.label("Riproduci Video") + '</a>';

        if ((data.name.indexOf('.mp3')>-1))
        html +=
            '<a href="kcact:play_mp3">' + this.label("Riproduci MP3") + '</a>';
            
            
            
        html +=
            '<a href="kcact:crypt">' + this.label("Cripta") + '</a>';
        html +=
            '<a href="kcact:copyfriends">' + this.label("Copia in Amico") + '</a>';
        html +=
            '<a href="kcact:copymysite">' + this.label("Copia in MySite") + '</a>';
        html +=
            '<a href="kcact:facebookshare">' + this.label("Facebook share") + '</a>';

        html += '</div>';

        $('#dialog').html(html);
//        $('#dialog').html('dai cazzo!');
        this.showMenu(e);

        $('.menu a[href="kcact:pick"]').click(function() {
            browser.returnFile(file);
            browser.hideDialog();
            return false;
        });

        $('.menu a[href="kcact:pick_thumb"]').click(function() {
            var path = browser.thumbsURL + '/' + browser.dir + '/' + data.name;
            browser.returnFile(path);
            browser.hideDialog();
            return false;
        });

        $('.menu a[href="kcact:edittext"]').click(function() {
			//alert(browser.dir +'/'+ data.name);
             text_edit(escape(browser.dir +'/'+ data.name));
           });
           
        $('.menu a[href="kcact:play"]').click(function() {
			//alert(browser.dir +'/'+ data.name);
             play_video(escape(browser.dir +'/'+ data.name));
           });
        $('.menu a[href="kcact:play_mp3"]').click(function() {
			//alert(browser.dir +'/'+ data.name);
             play_mp3(escape(browser.dir +'/'+ data.name));
           });




        $('.menu a[href="kcact:download"]').click(function() {
            var html = '<form id="downloadForm" method="post" action="' + browser.baseGetData('download') + '">' +
                '<input type="hidden" name="dir" />' +
                '<input type="hidden" name="file" />' +
            '</form>';
            $('#dialog').html(html);
            $('#downloadForm input').get(0).value = browser.dir;
            $('#downloadForm input').get(1).value = data.name;
            $('#downloadForm').submit();
            return false;
        });

        $('.menu a[href="kcact:crypt"]').click(function() {
                moveto_secure(browser.dir +"/" + data.name);	

           });
           
           
           
        $('.menu a[href="kcact:copymysite"]').click(function() {
                var pfiles = [];
                pfiles[0] = data.name;
                copy_to_mysite_m(browser.dir,pfiles);	

           });
        $('.menu a[href="kcact:copyfriends"]').click(function() {
                copy_to_friend(browser.dir +"/" + data.name);	

           });
        $('.menu a[href="kcact:selectall"]').click(function() {
                browser.hideDialog();
                select_all();	
                console.log("1083");
				
				var files = browser.files;
				//console.log(files);
            for (i = 0; i < browser.clipboard.length; i++)
                if ((browser.clipboard[i].name == data.name) &&
                    (browser.clipboard[i].dir == browser.dir)
                ) {
                    browser.hideDialog();
                    browser.alert(browser.label("This file is already added to the Clipboard."));
                    return false;
                }
            var cdata = data;
            cdata.dir = browser.dir;
            browser.clipboard[browser.clipboard.length] = cdata;
            browser.initClipboard();
            browser.hideDialog();
                return false;

           });
        $('.menu a[href="kcact:facebookshare"]').click(function() {
                fbs_click(browser.dir +"/" + data.name,"Crypt2Share.com");	

           });



        $('.menu a[href="kcact:clpbrdadd"]').click(function() {
            for (i = 0; i < browser.clipboard.length; i++)
                if ((browser.clipboard[i].name == data.name) &&
                    (browser.clipboard[i].dir == browser.dir)
                ) {
                    browser.hideDialog();
                    browser.alert(browser.label("This file is already added to the Clipboard."));
                    return false;
                }
            var cdata = data;
            cdata.dir = browser.dir;
            browser.clipboard[browser.clipboard.length] = cdata;
            browser.initClipboard();
            browser.hideDialog();
            return false;
        });

        $('.menu a[href="kcact:mv"]').click(function(e) {
            if (!data.writable) return false;
            browser.fileNameDialog(
                e, {dir: browser.dir, file: data.name},
                'newName', data.name, browser.baseGetData('rename'), {
                    title: "New file name:",
                    errEmpty: "Please enter new file name.",
                    errSlash: "Unallowable characters in file name.",
                    errDot: "File name shouldn't begins with '.'"
                },
                function() {
                    browser.refresh();
                }
            );
            return false;
        });

        $('.menu a[href="kcact:rm"]').click(function() {
            if (!data.writable) return false;
            browser.hideDialog();
            browser.confirm(browser.label("Are you sure you want to delete this file?"),
                function(callBack) {
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: browser.baseGetData('delete'),
                        data: {dir:browser.dir, file:data.name},
                        async: false,
                        success: function(data) {
                            if (callBack) callBack();
                            browser.clearClipboard();
                            if (browser.check4errors(data))
                                return;
                            browser.refresh();
                        },
                        error: function() {
                            if (callBack) callBack();
                            browser.alert(browser.label("Unknown error."));
                        }
                    });
                }
            );
            return false;
        });
    }

    $('.mobilemenu a[href="kcact:view"]').click(function() {
        browser.hideDialog();
        var ts = new Date().getTime();
        var showImage = function(data) {
            url = _.escapeDirs(browser.uploadURL + '/' + browser.dir + '/' + data.name) + '?ts=' + ts,
            $('#loading').html(browser.label("Loading image..."));
            $('#loading').css('display', 'inline');
            var img = new Image();
            img.src = url;
            img.onerror = function() {
                browser.lock = false;
                $('#loading').css('display', 'none');
                browser.alert(browser.label("Unknown error."));
                $(document).unbind('keydown');
                $(document).keydown(function(e) {
                    return !browser.selectAll(e);
                });
                browser.refresh();
            };
            var onImgLoad = function() {
                browser.lock = false;
                $('#files .file').each(function() {
                    if ($(this).data('name') == data.name)
                        browser.ssImage = this;
                });
                $('#loading').css('display', 'none');
                $('#dialog').html('<div class="slideshow"><img /></div>');
                $('#dialog img').attr({
                    src: url,
                    title: data.name
                }).fadeIn('fast', function() {
                    var o_w = $('#dialog').outerWidth();
                    var o_h = $('#dialog').outerHeight();
                    var f_w = $(window).width() - 30;
                    var f_h = $(window).height() - 30;
                    if ((o_w > f_w) || (o_h > f_h)) {
                        if ((f_w / f_h) > (o_w / o_h))
                            f_w = parseInt((o_w * f_h) / o_h);
                        else if ((f_w / f_h) < (o_w / o_h))
                            f_h = parseInt((o_h * f_w) / o_w);
                        $('#dialog img').attr({
                            width: f_w,
                            height: f_h
                        });
                    }
                    $('#dialog').unbind('click');
                    $('#dialog').click(function(e) {
                        browser.hideDialog();
                        $(document).unbind('keydown');
                        $(document).keydown(function(e) {
                            return !browser.selectAll(e);
                        });
                        if (browser.ssImage) {
                            browser.selectFile($(browser.ssImage), e);
                        }
                    });
                    browser.showDialog();
                    var images = [];
                    $.each(browser.files, function(i, file) {
                        if (file.thumb || file.smallThumb)
                            images[images.length] = file;
                    });
                    if (images.length)
                        $.each(images, function(i, image) {
                            if (image.name == data.name) {
                                $(document).unbind('keydown');
                                $(document).keydown(function(e) {
                                    if (images.length > 1) {
                                        if (!browser.lock && (e.keyCode == 37)) {
                                            var nimg = i
                                                ? images[i - 1]
                                                : images[images.length - 1];
                                            browser.lock = true;
                                            showImage(nimg);
                                        }
                                        if (!browser.lock && (e.keyCode == 39)) {
                                            var nimg = (i >= images.length - 1)
                                                ? images[0]
                                                : images[i + 1];
                                            browser.lock = true;
                                            showImage(nimg);
                                        }
                                    }
                                    if (e.keyCode == 27) {
                                        browser.hideDialog();
                                        $(document).unbind('keydown');
                                        $(document).keydown(function(e) {
                                            return !browser.selectAll(e);
                                        });
                                    }
                                });
                            }
                        });
                });
            };
            if (img.complete)
                onImgLoad();
            else
                img.onload = onImgLoad;
        };
        showImage(data);
        return false;
    });



         $('.menu a[href="kcact:view"]').click(function() {
                show_gallery(browser.dir, data.name);	

           });
    
    $('.menu a[href="kcact:_view"]').click(function() {
        browser.hideDialog();
        var ts = new Date().getTime();
        var showImage = function(data) {
            url = _.escapeDirs(browser.uploadURL + '/' + browser.dir + '/' + data.name) + '?ts=' + ts,
            $('#loading').html(browser.label("Loading image..."));
            $('#loading').css('display', 'inline');
            var img = new Image();
            img.src = url;
            img.onerror = function() {
                browser.lock = false;
                $('#loading').css('display', 'none');
                browser.alert(browser.label("Unknown error."));
                $(document).unbind('keydown');
                $(document).keydown(function(e) {
                    return !browser.selectAll(e);
                });
                browser.refresh();
            };
            var onImgLoad = function() {
                browser.lock = false;
                $('#files .file').each(function() {
                    if ($(this).data('name') == data.name)
                        browser.ssImage = this;
                });
                $('#loading').css('display', 'none');
                $('#dialog').html('<div class="slideshow"><img /></div>');
                $('#dialog img').attr({
                    src: url,
                    title: data.name
                }).fadeIn('fast', function() {
                    var o_w = $('#dialog').outerWidth();
                    var o_h = $('#dialog').outerHeight();
                    var f_w = $(window).width() - 30;
                    var f_h = $(window).height() - 30;
                    if ((o_w > f_w) || (o_h > f_h)) {
                        if ((f_w / f_h) > (o_w / o_h))
                            f_w = parseInt((o_w * f_h) / o_h);
                        else if ((f_w / f_h) < (o_w / o_h))
                            f_h = parseInt((o_h * f_w) / o_w);
                        $('#dialog img').attr({
                            width: f_w,
                            height: f_h
                        });
                    }
                    $('#dialog').unbind('click');
                    //qui
                    //$('#mobile').unbind('click');
                    $('#dialog').click(function(e) {
                        browser.hideDialog();
                        $(document).unbind('keydown');
                        $(document).keydown(function(e) {
                            return !browser.selectAll(e);
                        });
                        if (browser.ssImage) {
                            browser.selectFile($(browser.ssImage), e);
                        }
                    });
                    browser.showDialog();
                    var images = [];
                    $.each(browser.files, function(i, file) {
                        if (file.thumb || file.smallThumb)
                            images[images.length] = file;
                    });
                    if (images.length)
                        $.each(images, function(i, image) {
                            if (image.name == data.name) {
                                $(document).unbind('keydown');
                                $(document).keydown(function(e) {
                                    if (images.length > 1) {
                                        if (!browser.lock && (e.keyCode == 37)) {
                                            var nimg = i
                                                ? images[i - 1]
                                                : images[images.length - 1];
                                            browser.lock = true;
                                            showImage(nimg);
                                        }
                                        if (!browser.lock && (e.keyCode == 39)) {
                                            var nimg = (i >= images.length - 1)
                                                ? images[0]
                                                : images[i + 1];
                                            browser.lock = true;
                                            showImage(nimg);
                                        }
                                    }
                                    if (e.keyCode == 27) {
                                        browser.hideDialog();
                                        $(document).unbind('keydown');
                                        $(document).keydown(function(e) {
                                            return !browser.selectAll(e);
                                        });
                                    }
                                });
                            }
                        });
                });
            };
            if (img.complete)
                onImgLoad();
            else
                img.onload = onImgLoad;
        };
        showImage(data);
        return false;
    });    
    
    
    
    
    
};
