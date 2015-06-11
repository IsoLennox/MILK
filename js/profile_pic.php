

<?php 
session_start(); 
header("Content-type: application/javascript");?>


resizeableImage = function(image_target, file){
  // Some variable and settings
  var $container,
      orig_src = new Image(),
      form_file = file,
      image_target = $(image_target).get(0),
      event_state = {},
      constrain = true,
      min_width = 60, // Change as required
      min_height = 60,
      max_width = 800, // Change as required
      max_height = 900,
      resize_canvas = document.createElement('canvas');
     

  init = function(){
    
    // When resizing, we will always use this copy of the original as the base
    orig_src.src=image_target.src;

    // Wrap the image with the container and add resize handles
    $('.resize-image').wrap('<div class="resize-container"></div>')
    .before('<span class="resize-handle resize-handle-nw"></span>')
    .before('<span class="resize-handle resize-handle-ne"></span>')
    .after('<span class="resize-handle resize-handle-se"></span>')
    .after('<span class="resize-handle resize-handle-sw"></span>');
    
    // Assign the container to a variable
    $container =  $('.resize-image').parent('.resize-container');
    

    // Add events
    $container.on('mousedown touchstart', '.resize-handle', startResize);
    $container.on('mousedown touchstart', 'img', startMoving);
    $('.js-crop').on('click', crop);
    
  }; // end init()

  startResize = function(e){
    e.preventDefault();
    e.stopPropagation();
    saveEventState(e);
    $(document).on('mousemove touchmove', resizing);
    $(document).on('mouseup touchend', endResize);
  }; // end startResize()

  endResize = function(e){
    e.preventDefault();
    $(document).off('mouseup touchend', endResize);
    $(document).off('mousemove touchmove', resizing);
  }; // end endResize()

  saveEventState = function(e){
    // Save the initial event details and container state
    event_state.container_width = $container.width();
    event_state.container_height = $container.height();
    event_state.container_left = $container.offset().left; 
    event_state.container_top = $container.offset().top;
    event_state.mouse_x = (e.clientX || e.pageX || e.originalEvent.touches[0].clientX) + $(window).scrollLeft(); 
    event_state.mouse_y = (e.clientY || e.pageY || e.originalEvent.touches[0].clientY) + $(window).scrollTop();
  
  // This is a fix for mobile safari
  // For some reason it does not allow a direct copy of the touches property
  if(typeof e.originalEvent.touches !== 'undefined'){
    event_state.touches = [];
    $.each(e.originalEvent.touches, function(i, ob){
      event_state.touches[i] = {};
      event_state.touches[i].clientX = 0+ob.clientX;
      event_state.touches[i].clientY = 0+ob.clientY;
    });
  }
    event_state.evnt = e;
  }; // end saveEventState()

  resizing = function(e){
    var mouse={},width,height,left,top,offset=$container.offset();
    mouse.x = (e.clientX || e.pageX || e.originalEvent.touches[0].clientX) + $(window).scrollLeft(); 
    mouse.y = (e.clientY || e.pageY || e.originalEvent.touches[0].clientY) + $(window).scrollTop();
    
    // Position image differently depending on the corner dragged and constraints
    if( $(event_state.evnt.target).hasClass('resize-handle-se') ){
      width = mouse.x - event_state.container_left;
      height = mouse.y  - event_state.container_top;
      left = event_state.container_left;
      top = event_state.container_top;
    } else if($(event_state.evnt.target).hasClass('resize-handle-sw') ){
      width = event_state.container_width - (mouse.x - event_state.container_left);
      height = mouse.y  - event_state.container_top;
      left = mouse.x;
      top = event_state.container_top;
    } else if($(event_state.evnt.target).hasClass('resize-handle-nw') ){
      width = event_state.container_width - (mouse.x - event_state.container_left);
      height = event_state.container_height - (mouse.y - event_state.container_top);
      left = mouse.x;
      top = mouse.y;
      if(constrain || e.shiftKey){
        top = mouse.y - ((width / orig_src.width * orig_src.height) - height);
      }
    } else if($(event_state.evnt.target).hasClass('resize-handle-ne') ){
      width = mouse.x - event_state.container_left;
      height = event_state.container_height - (mouse.y - event_state.container_top);
      left = event_state.container_left;
      top = mouse.y;
      if(constrain || e.shiftKey){
        top = mouse.y - ((width / orig_src.width * orig_src.height) - height);
      }
    }
  
    // Optionally maintain aspect ratio
    if(constrain || e.shiftKey){
      height = width / orig_src.width * orig_src.height;
    }

    if(width > min_width && height > min_height && width < max_width && height < max_height){
      // To improve performance you might limit how often resizeImage() is called
      resizeImage(width, height);  
      // Without this Firefox will not re-calculate the the image dimensions until drag end
      $container.offset({'left': left, 'top': top});
    }
  };// end resizing)()

  resizeImage = function(width, height){
    resize_canvas.width = width;
    resize_canvas.height = height;
    resize_canvas.getContext('2d').drawImage(orig_src, 0, 0, width, height);   
    $(image_target).attr('src', resize_canvas.toDataURL("image/png"));  
  }; // end resizeImage()

  startMoving = function(e){
    e.preventDefault();
    e.stopPropagation();
    saveEventState(e);
    $(document).on('mousemove touchmove', moving);
    $(document).on('mouseup touchend', endMoving);
  }; // end startMoving()

  endMoving = function(e){
    e.preventDefault();
    $(document).off('mouseup touchend', endMoving);
    $(document).off('mousemove touchmove', moving);
  }; // end endMoving()

  moving = function(e){
    var  mouse={}, touches;
    e.preventDefault();
    e.stopPropagation();
    
    touches = e.originalEvent.touches;
    
    mouse.x = (e.clientX || e.pageX || touches[0].clientX) + $(window).scrollLeft(); 
    mouse.y = (e.clientY || e.pageY || touches[0].clientY) + $(window).scrollTop();
    $container.offset({
      'left': mouse.x - ( event_state.mouse_x - event_state.container_left ),
      'top': mouse.y - ( event_state.mouse_y - event_state.container_top ) 
    });
    // Watch for pinch zoom gesture while moving
    if(event_state.touches && event_state.touches.length > 1 && touches.length > 1){
      var width = event_state.container_width, height = event_state.container_height;
      var a = event_state.touches[0].clientX - event_state.touches[1].clientX;
      a = a * a; 
      var b = event_state.touches[0].clientY - event_state.touches[1].clientY;
      b = b * b; 
      var dist1 = Math.sqrt( a + b );
      
      a = e.originalEvent.touches[0].clientX - touches[1].clientX;
      a = a * a; 
      b = e.originalEvent.touches[0].clientY - touches[1].clientY;
      b = b * b; 
      var dist2 = Math.sqrt( a + b );

      var ratio = dist2 /dist1;

      width = width * ratio;
      height = height * ratio;
      // To improve performance you might limit how often resizeImage() is called
      resizeImage(width, height);
    }
  };// end moving()

  crop = function(){
    //Find the part of the image that is inside the crop box
    // var canvas_blob,
    var crop_canvas,
    left = $('.overlay').offset().left - $container.offset().left,
    top =  $('.overlay').offset().top - $container.offset().top,
    width = $('.overlay').width(),
    height = $('.overlay').height();
    
    crop_canvas = document.createElement('canvas');
    crop_canvas.width = width;
    crop_canvas.height = height;    
    
    crop_canvas.getContext('2d').drawImage($('.resize-image')[0], left, top, width, height, 0, 0, width, height);
    var blob = dataURItoBlob(crop_canvas.toDataURL("image/png"));
    blob.name = "profile_img.png";
    blob.tmp_name = crop_canvas.toDataURL("image/png");
    
   

    var file_data = $('image_upload');
    file_data.serialize();
    
    var form_data = new FormData();
    var user_id = "<?php echo $_SESSION['user_id'] ?>"; 
                      
    form_data.append('image', blob);
                                
    $.ajax({
      url: 'upload_profile_img.php', // point to server-side PHP script 
      // dataType: 'text',  // what to expect back from the PHP script, if anything
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,                         
      type: 'POST',
      success: function(php_script_response){
        $('.overlay').hide();
        $('.btn-crop').hide();
        $('resize-image').attr('src', 'crop_canvas.toDataURL("image/png")');
        window.location.assign("profile.php?user_id=" + user_id);
      }
    });  // end ajax()
    // window.open(crop_canvas.toDataURL("image/png"));
  }; // end crop()

  dataURItoBlob = function(dataURI) {
    // convert base64/URLEncoded data component to raw binary data held in a string
    
    var byteString;
    if (dataURI.split(',')[0].indexOf('base64') >= 0)
        byteString = atob(dataURI.split(',')[1]);
    else
        byteString = unescape(dataURI.split(',')[1]);

    // separate out the mime component
    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
    
    // write the bytes of the string to a typed array
    var ia = new Uint8Array(byteString.length);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);        
    }
    return new Blob([ia], {type:mimeString});
  }; // end dataURItoBlob
  init();
};
// render the image in our view
function renderImage(file, event) {

  // generate a new FileReader object
  var reader = new FileReader();

  // inject an image with the src url
  reader.onload = function(event) {
    the_url = dataURL;
    $('resize-container').html("<img src='" + the_url + "' />");
  };
  reader.onload = function(e) {
    window.dataURL = reader.result;
  };
 
  // when the file is read it triggers the onload event above.
  reader.readAsDataURL(file);
}


$(document).ready(function() {
  var file;
  $('.overlay').hide();
  $('.btn-crop').hide();
  
  
    // $('#image_upload').submit(function(evt){    
    //     evt.preventDefault(); 
    // }); // end submit()
    $('#fileToUpload').change(function(event){
        
        file = event.target.files[0]; // FileList object

        renderImage(file, event);
        
       
    });
    $('#submit').click(function(e){

      $('.overlay').show();
      $('.btn-crop').show();
      var $f = $('#fileToUpload').val();      
      if($f == ''){
        e.preventDefault();
        
      } else {
        e.preventDefault();
        var name = file.name;
        var size = file.size;
        var type = file.type;
        file.src = window.dataURL;     
      }
        
          

      if(name.length < 1) {
        alert('no file selected');
        }
        else if(file.size > 5000000) {
            alert("File is to big");
        }
        else if(file.type != 'image/png' && file.type != 'image/jpg' && !file.type != 'image/gif' && file.type != 'image/jpeg' ) {
          alert("File doesnt match png, jpg or gif");
        }
        else {

          $('.resize-image').attr('src', window.dataURL);
         
          resizeableImage($('.resize-image'), file);
        }
      
        
    }); // end submit
}); // end ready
