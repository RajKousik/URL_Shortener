//getting required elements

const form = document.querySelector(".container form");
const fullURL = form.querySelector("input");
const shortenBtn = form.querySelector("button");
const blurEffect = document.querySelector(".blur-effect");
const popupBox = document.querySelector(".popup-box");
const shortenUrl = popupBox.querySelector("input");
const saveBtn = popupBox.querySelector("button");
const form2 = popupBox.querySelector("form");
const copyBtn = popupBox.querySelector(".fa-copy");
const infoBox = popupBox.querySelector(".info-box");

form.onsubmit = (e) =>{
    e.preventDefault();
}


shortenBtn.onclick = () =>{
    //ajax coding

    let xhr = new XMLHttpRequest();
    xhr.open("POST","php/url-control.php", true);
    xhr.onload = () =>{
        if(xhr.readyState == 4 && xhr.status == 200)
        {
            let data = xhr.response;
            if(data.length <= 5){
                blurEffect.style.display = "block";
                popupBox.classList.add("show");

                let domain = "localhost/URL_Shortener/";
                shortenUrl.value = domain + data;
        
                copyBtn.onclick = () =>{
                    shortenUrl.select();
                    document.execCommand("copy");
                }
                
                form2.onsubmit = (e) =>{
                    e.preventDefault();
                }

                saveBtn.onclick = () =>{

                    let xhr2 = new XMLHttpRequest();
                    xhr2.open("POST","php/save-url.php", true);
                    xhr2.onload = () =>{
                        if(xhr2.readyState == 4 && xhr2.status == 200)
                        {
                            let data = xhr2.response;
                            if(data == "success"){
                                location.reload();
                            }else{
                                infoBox.innerText = data;
                                infoBox.classList.add("error");
                            }
                        }
                    }
                    let short_url = shortenUrl.value;
                    let hidden_url = data;
                    xhr2.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    xhr2.send("shorten_url="+short_url+"&hidden_url="+hidden_url);;
                }
            }
            else
            {
                alert(data);
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}
