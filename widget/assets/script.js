
    let tabs = document.querySelectorAll('#template_chooser_widget .tab');
    if(tabs){
    
        tabs.forEach(h=>{
            h.addEventListener("click", function(){
                // Reset Data
                if(document.querySelector(".this_current_form")){
                        // get image url which is clicked
                        let selected_img = document.querySelector("#template_chooser_widget .this_current_form .span img");
    
                        document.querySelector("#template_chooser_widget .tabs-content .items .current_item .img").prepend(selected_img);
    
                        // remove filled level color
                        document.querySelector(".this_current_form .levels .two").classList.remove("filled");
                        document.querySelector(".this_current_form .levels").classList.remove("line_levels");
                        // hidding the form
                        document.querySelector(".this_current_form .form_data").classList.add("d-none");
    
                        // show the Images section
                        var img_sec = document.querySelector(".hide_image_section");
                        img_sec.classList.remove("d-none");
                        img_sec.classList.remove("hide_image_section");
    
                        // Reset Data
                        document.querySelector(".current_item").classList.remove("current_item");
                        // remvoe the class to get previous section
                        document.querySelector(".this_current_form").classList.remove("this_current_form");
                }
                // end Reset Data
    
                document.querySelectorAll(".content-tabs").forEach(el=>{
                    el.classList.add("d-none");
                });
    
                document.querySelectorAll("#template_chooser_widget .active1").forEach(tab=>{
                    tab.classList.remove("active1");
                })
                this.classList.add("active1");
                document.getElementById(this.getAttribute('data-tab')).classList.remove("d-none");
            });
        });
    
        // get all images
        let content_items = document.querySelectorAll("#template_chooser_widget .tabs-content .items .item");
        content_items.forEach(item=>{
            item.addEventListener("click", function(){
                // adding unique class on clicked image element
                this.classList.add("current_item");
                // Artificial Data-------------------------------------------------------------
                // get image url which is clicked
                let selected_img = document.querySelector("#template_chooser_widget .tabs-content .items .current_item img");
    
                // Hide the Images section
                this.parentElement.classList.add("hide_image_section");
                document.querySelector(".hide_image_section").classList.add("d-none");
                
                // add the class to get current form
                this.parentElement.parentElement.classList.add("this_current_form");
                // filled level color
                document.querySelector(".this_current_form .levels .two").classList.add("filled");
                document.querySelector(".this_current_form .levels").classList.add("line_levels");
                // showing the form
                document.querySelector(".this_current_form .form_data").classList.remove("d-none");
    
                document.querySelector("#template_chooser_widget .this_current_form .span").innerHTML = "";
                document.querySelector("#template_chooser_widget .this_current_form .span").appendChild(selected_img);
    
    
            // ON Form Submit
            jQuery(".this_current_form .form_data form").submit(function (event) {
                event.preventDefault();
                // Collecting the whole form data

            document.querySelector(".this_current_form .pre_loader").classList.remove("d-none");
              file_data = jQuery('.this_current_form #fileimg').prop('files')[0];
              form_data = new FormData();
              form_data.append('file', file_data);
              form_data.append('action', 'custom_set_form');
              form_data.append('security', blog.security);
              form_data.append('selectedImage', jQuery(".this_current_form .span img").attr('src'));
              form_data.append('selectedImageAlt', jQuery(".this_current_form .span img").attr('alt'));
              form_data.append('Name', jQuery(".this_current_form #fullname").val());
              form_data.append('bookingEmail', jQuery(".this_current_form #booking_email").val());
              form_data.append('eventDate', jQuery(".this_current_form #eventdate").val());
              form_data.append('phone', jQuery('.this_current_form #telphone_no').val());
              form_data.append('message', jQuery('.this_current_form #text_message').val());
              form_data.append('sent_email', jQuery("#template_chooser_widget").attr('data-email'));
    
          
              // Transfering data through AJAX
              jQuery.ajax({
                url: blog.ajaxurl,
                type: 'POST',
                contentType: false,
                processData: false,
                data: form_data,
                success: function (response) {
                    if(response == "email sent"){
                        document.querySelector(".this_current_form .pre_loader").classList.add("d-none");
                        document.querySelector("#template_popup_message").classList.remove("d-none");
                        jQuery(".this_current_form .form_data form")[0].reset();
                    }else
                    if(response == "incorrect"){
                        jQuery("#template_chooser_widget .this_current_form #booking_email").css("outline", "1px solid Red");
                    }
                    console.log(response);
                }
              });
             
            });
    
            });
            
        });
    
        prev_btn = document.querySelectorAll(".form_data .prev");
    
        prev_btn.forEach(btn=>{
                btn.addEventListener("click", function(){
                    if(btn.parentElement.parentElement.parentElement.parentElement.classList.contains("this_current_form")){
    
                        // get image url which is clicked
                        let selected_img = document.querySelector("#template_chooser_widget .this_current_form .span img");
    
                        document.querySelector("#template_chooser_widget .tabs-content .items .current_item .img").prepend(selected_img);
    
                        // remove filled level color
                        document.querySelector(".this_current_form .levels .two").classList.remove("filled");
                        document.querySelector(".this_current_form .levels").classList.remove("line_levels");
                        // hidding the form
                        document.querySelector(".this_current_form .form_data").classList.add("d-none");
    
                        // show the Images section
                        var img_sec = document.querySelector(".hide_image_section");
                        img_sec.classList.remove("d-none");
                        img_sec.classList.remove("hide_image_section");
    
                        // Reset Data
                        document.querySelector(".current_item").classList.remove("current_item");
                        // remvoe the class to get previous section
                        document.querySelector(".this_current_form").classList.remove("this_current_form");
                    }
                });
            
        });

        document.querySelector("#template_popup_message").addEventListener("click", function(){
            this.classList.add("d-none");
        })
    
    }
