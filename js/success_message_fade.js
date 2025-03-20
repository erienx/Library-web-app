document.addEventListener("DOMContentLoaded", function (){
    const successMsg = document.querySelector(".success-message");
    if (successMsg){
        setTimeout(()=>{
            successMsg.style.transition = "opacity 0.5s ease";
            successMsg.style.opacity = "0";
            setTimeout(()=> successMsg.remove(), 500);
            }, 2000)
    }
});