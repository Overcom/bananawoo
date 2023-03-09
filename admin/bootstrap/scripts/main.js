jQuery(document).ready(function ($) {

    $("#viewModal").click(() => {
        $("#modalNuevo").modal("show");
    });

    /**
     *  tomar el boleano de un check
     * @param {boolean} selector 
     * @returns boolean
     */
    function checkBolean(selector) {
        return $(selector).prop('checked')
    }

    /**
     * Anima los checkbox mediante
     * id  como parámetro
     * 
     * @param {string} checkbox "#chekcbox" 
     * @param {string} boxProduct "#boxProduct" 
     */
    function checkBox(checkbox, boxProduct) {
        
        $(boxProduct).click(() => {
            //console.log( checkbox );
            if (checkBolean(checkbox) == true) {
                console.log('btn on');
                //console.log(checkbox  );
                $(boxProduct).css({
                    "background-color": "#2088ff",
                    "color": "#fafcff",
                    "transition": "0.3s"
                });
            } else {
                $(boxProduct).css({
                    "background-color": "#fafcff",
                    "color": "#3f3f3f",
                    "transition": "0.3s"
                });
                //console.log('btn of');
            }
        });
    }
    checkBox("#producto","#box-producto");
    checkBox("#lista","#box-lista");
    checkBox("#categoria","#box-categoria");
    checkBox("#stock","#box-stock");
    checkBox("#elemento","#box-elemento");
    checkBox("#todo","#box-todo");

    // var idProduct= document.querySelector('#delete').value;

    // $('#delete').click(()=> {
    //     console.log(idProduct);
    // })
});