var toggle = document.querySelector('.toggle');
var navigation = document.querySelector('.navigation');
var main = document.querySelector('.main');
toggle.onclick = function () {
    navigation.classList.toggle('active')
    main.classList.toggle('active')
}
let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e) => {
        let arrowParent = e.target.parentElement.parentElement;
        arrowParent.classList.toggle("showMenu");
    });
}
var list = document.querySelectorAll('.navigation .a');
function activeLink() {
    list.forEach((item) =>
        item.classList.remove('hovered'));
    this.classList.add("hovered");
}
list.forEach((item) =>
    item.addEventListener('click', activeLink));

function Fase(id, m, t) {
    Swal.fire({
        title: 'CONFIRMAR',
        text: m,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: 'rgb(5,1,22',
        cancelButtonColor: 'rgb(56, 54, 54)',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Aceptar',
    }).then((result) => {
        if (result.value) {
            Livewire.dispatch('next', { id: id })
            Swal.fire({
                icon: 'success',
                title: t,
                showConfirmButton: false,
                timer: 1500
            })
        }
    })
};





function Confirm(id) {
    Swal.fire({
        title: 'CONFIRMAR',
        text: '¿DESEAS ELIMINAR EL REGISTRO?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: 'rgb(78, 0, 0)',
        cancelButtonColor: 'rgb(5, 1, 22)',
        cancelButtonText: '<i class="fas fa-ban"></i> Cancelar',
        confirmButtonText: '<i class="fas fa-times"></i> Eliminar',

    }).then((result) => {
        if (result.value) {
            Livewire.dispatch('delete', { id: id })
            Swal.fire({
                icon: 'success',
                title: 'Registro eliminado',
                showConfirmButton: false,
                timer: 1500
            })
        }
    });
}
function notify(ms) {
    Toast.fire({
        icon: ms['icon'],
        title: ms['title'],
        html: ms['text']
    });
}

window.Toast = Swal.mixin({
    toast: true,
    position: "top-right",
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
    showCloseButton: true,
    customClass: {
        popup: 'border-primary',
        title: 'mx-1 fw-bold',
    },
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

document.addEventListener('livewire:init', () => {
    Livewire.on('closeModal', Msg => {
        // Selecciona el elemento que tiene el atributo 'data-bs-dismiss="modal"'
        var closeButton = document.querySelector('[data-bs-dismiss="modal"]');

        // Verifica si el elemento existe y luego simula el clic en él
        if (closeButton) {
            closeButton.click();
        }
    });
    Livewire.on('notify', (Msg) => {
        notify(Msg)
    })


});

/*
        let myModal=new Modal(document.getElementById('theModal'));

        var r=new Modal(document.getElementById('formModal'));

        document.addEventListener('DOMContentLoaded',function(){
            window.livewire.on('showModal',Msg=>{
                myModal.show();
            });
            window.livewire.on('closeModal',Msg=>{
                myModal.hide();
                r.hide();
                if(Msg!='')
                {
                    notify(Msg);
                }
            });

            window.livewire.on('notify',Msg=>{
                notify(Msg);
            });
        });


        */


/*         document.addEventListener('livewire:init', () => {
            Livewire.on('closeModal', (event) => {
                $('#theModal').modal('hide');

            });
         });
 */

/* var modalForm=new bootstrap.Modal(document.getElementById('theModal'){
    keyboard=false
});
        document.addEventListener('DOMContentLoaded', function () {

            Livewire.on('closeModal', (event) => {
                modalForm.hide()

            });
        }); 
        
 */
/*         var spinner = function () {
            setTimeout(function () {
                if ($('#spinner').length > 0) {
                    $('#spinner').removeClass('show');
                }
            }, 1);
        };
        spinner();
 */