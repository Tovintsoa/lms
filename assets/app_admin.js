import {askRemoveGenerique, removeGenerique} from "./app_admin_fonction";
$(document).ready(function(){
    const btn_delete = ".btn-delete";
    const modal = ".modal_effacer";


    $(document).on("click",btn_delete,function(){
        askRemoveGenerique(this,modal)
    });

});