var dialog =document.querySelector('#dlogs');
var form_button= document.querySelector('#confirmBtn');
var selectit = document.querySelector('select');

var button =(document.querySelectorAll('.round-button'));
var count= 0;
button.forEach((but)=>{
    but.addEventListener('click',()=>{
        count=count+1;
       if(count >3)
       {
        var hd = document.createElement('Button');
        hd.id ="header";
        hd.innerHTML = "Do You Want To Change Playlist?";
        hd.addEventListener('click', function onOpen(){
            if (typeof dialog.showModal === "function") {
                dialog.showModal();
              } else {
                alert("The <dialog> API is not supported by this browser");
              }
              selectit.addEventListener('change',function onSelect(e){
               form_button.value = selectit.value;
              })
             
              dialog.addEventListener('close', function onClose() {
                 
               window.location=`/delete.php?r=${dialog.returnValue}`;
              })
             
           
               
              
        });
        document.body.appendChild(hd);
       

       }
    })
});
