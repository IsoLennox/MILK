
// define some of the variables and initialize the Canvas and the 
// target image.
var resizeableImage = function(image_target) {
    var $container,
    orig_src = new Image(),
    image_target = $(image_target).get(0),
    event_state = {},
    constrain = false,
    min_width = 60,
    min_height = 60,
    max_width = 800,
    max_height = 900,
    resize_canvas = document.createElement('canvas');

    // create the init function that will be called immediately. This function wraps the 
    // image with a container, creates resize handles and makes a copy of the original image used for resizing
    init = function(){

        // Create a new image with a copy of the original src
        // When resizing, we will always use this original copy as the base
        orig_src.src=image_target.src;

        // Add resize handles
        $(image_target).wrap('<div class="resize-container"></div>')
        .before('<span class="resize-handle resize-handle-nw"></span>')
        .before('<span class="resize-handle resize-handle-ne"></span>')
        .after('<span class="resize-handle resize-handle-se"></span>')
        .after('<span class="resize-handle resize-handle-sw"></span>');

        // Get a variable for the container
        $container =  $(image_target).parent('.resize-container');

        // Add events
        $container.on('mousedown', '.resize-handle', startResize);
    };

    init();
}
    
// The startResize and endResize functions do very little other than tell the browser 
// to start paying attention to where the mouse is moving and when to stop paying attention.
startResize = function(e){
    e.preventDefault();
    e.stopPropagation();
    saveEventState(e);
    $(document).on('mousemove', resizing);
    $(document).on('mouseup', endResize);
};

endResize = function(e){
    e.preventDefault();
    $(document).off('mouseup touchend', endResize);
    $(document).off('mousemove touchmove', resizing);
};

// take a snapshot of the container dimensions and other key data points. We store these in a 
// variable named event_state and use them later as a point of reference while resizing to work out the change in height and width.

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
}

// The resizing function is where most of the action happens. This function is constantly
// invoked while the user is dragging one of the resize handles. Every time this function 
// is called we work out the new width and height by taking the current position of the mouse 
// relative to the initial position of the corner we are dragging.

resizing = function(e){ 
    var mouse={},width,height,left,top,offset=$container.offset();
    mouse.x = (e.clientX || e.pageX || e.originalEvent.touches[0].clientX) + $(window).scrollLeft(); 
    mouse.y = (e.clientY || e.pageY || e.originalEvent.touches[0].clientY) + $(window).scrollTop();

    width = mouse.x - event_state.container_left;
    height = mouse.y  - event_state.container_top;
    left = event_state.container_left;
    top = event_state.container_top;
    // add the option to constrain the image dimensions when toggled using the shift key or a variable.
    if(constrain || e.shiftKey){
        height = width / orig_src.width * orig_src.height;
    }
    // resize the image, but only if the new width and height are not outside the bounds of the min and max variables we initially set
    if(width > min_width && height > min_height && width < max_width && height < max_height){
      resizeImage(width, height);  
      // Without this Firefox will not re-calculate the the image dimensions until drag end
      $container.offset({'left': left, 'top': top});        
    }
}

resizeImage = function(width, height){
    resize_canvas.width = width;
    resize_canvas.height = height;
    resize_canvas.getContext('2d').drawImage(orig_src, 0, 0, width, height);   
    $(image_target).attr('src', resize_canvas.toDataURL("image/png"));  
};


function handleFile(evt) {

    $(':file').change(function(event){
            var file = evt.target.files[0]; // FileList object
        });
}
     

    
        // Only process image files.
        if (!file.type.match('image.*')) {
          alert('not an image');
        }

        var reader = new FileReader();
        // Read in the image file as a data URL.
        reader.readAsDataURL(file);
    }
} // end function

document.getElementById('fileToUpload').addEventListener('change', handleFile, false);








// $(document).ready(function() {
   
//     $('#image_upload').submit(function(evt){    
//         evt.preventDefault(); 
//     }); // end submit()
    
//     var file;
//     for (var i = 0; file = files[i]; i++) {
//     document.write(file);
//   }
    
//     $('#submit').click(function(evt){
//         if($('#fileToUpload').val() == ''){
//             evt.preventDefault();
//             console.log('false');
//             return false;
//         } else {
//             evt.preventDefault();
            
//             console.log(file);
//             var name = file.name;
//             var size = file.size;
//             var type = file.type;
//             console.log(name, size, type);
            
            

//             if(name.length < 1) {
//                 alert('no file selected');
//             }
//             else if(file.size > 5000000) {
//                 alert("File is to big");
//             }
//             else if(file.type != 'image/png' && file.type != 'image/jpg' && !file.type != 'image/gif' && file.type != 'image/jpeg' ) {
//                 alert("File doesnt match png, jpg or gif");
//             }
//             else {

//                 resizeableImage(file.files[0]);
//             }
//         } // end if
        
//     });

// });