/*
   Wait for window to finish loading, then set event listeners for the body to procress the events
*/
window.onload = function() {
   var files = null;
   window.addEventListener('drop',dropEvent,false);
   window.addEventListener('drageneter',preventEvent,false);
   window.addEventListener('dragexit',preventEvent,false);
   window.addEventListener('dragover',preventEvent,false);
}
/*
   Stop Browser from Navigating to File / Default Handeling
*/
function preventEvent(e) {
   e.stopPropagation();
   e.preventDefault();
   return false;
}
/*
   When a file is dropped into the browser, the "drop" event listener points to this function.
*/
function dropEvent(e) {
   preventEvent(e);
   // Save all dropped files to global variable "files"
   files = e.dataTransfer.files;
   // Check if files were really dropped or not
   if(files.length > 0) {
      // Build an output display to show progress
      var output = '';
      var bg = null;
      for(var i = 0; i < files.length; i++) {
         if(bg == 'background-color:#ffffff;')
            bg = 'background-color:#bbbbbb;'
         else
            bg = 'background-color:#ffffff;';
         output += '<div style="height:20px;' + bg + '"><div style="float:left"><strong>' + escape(files[i].name) + '</strong></div><div class="progressbar"><div id="progress-child-' + i + '"></div></div><div style="clear:both"></div></div>';
      }
      document.getElementById('process').innerHTML = output;
      // Call function to upload files, starting at File[0]
      setTimeout(function(){uploadFiles(0);},100);
   }
   return false;
}
function uploadFiles(i) {
   var req = new XMLHttpRequest();
   var formdata = new FormData();
   req.upload.onprogress = function(e) {
   document.getElementById('progress-child-' + i).style.width = (e.position * 100 / e.totalSize) + '%';
}
req.onreadystatechange = function() {
   if(req.readyState == 4) {
      // Set Progress to 100% when finished
      document.getElementById('progress-child-' + i).style.width = '100%';
      if(req.status != 200) {
         // Turn Progress Red if Error
         document.getElementById('progress-child-' + i).style.backgroundColor = "#ff0000";
      }
      ++i;
      // If more files, upload the next one
      if(i < files.length) {
         uploadFiles(i);
      }else{
         // After all uploads, refresh page
         //window.location.href=window.location.href;
      }
   }
}
// Create form data for the image so the PHP file can progress it
formdata.append("image", files[i]);
req.open("POST","upload.php",true);
req.send(formdata);
}