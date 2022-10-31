// window.onload = () => {
//     const FiltersForm = document.querySelector("#filters");

//     document.querySelectorAll('#filters input').forEach(input => {
//         input.addEventListener("change", () => {
//             const Form = new FormData(FiltersForm);

//             const Params = new URLSearchParams();

//             Form.forEach((value, key) => {
//                 Params.append(key, value);
//             });

//             const Url = new URL(window.location.href);

//             fetch(Url.pathname + "" + Params.toString() + "&ajax=1", {
//                 headers: {
//                     "X-Requested-With": "XMLHttpRequest"
//                 }
//             }).then(response => {
//                 console.log(response);
//             }).catch(e => alert(e));
//         });
//     })
// }

// function userFilterChoice()
// {
//     const radio = document.getElementsByName('choice');
//     const partners = document.querySelectorAll('ROLE_PARTNER');
//     const franchises = document.querySelectorAll('ROLE_FRANCHISE');
//     const admin = document.querySelectorAll('ROLE_ADMIN');

//     for (let i = 0; i < radio.length; i++)
//     {
//         if(radio[i].checked)
//         {
//             if(radio[i].value === 'partners')
//             {
//                 console.log(franchises);
//                 franchises.classList.add('d-none');
//             }
            
//         }
//     }
// }