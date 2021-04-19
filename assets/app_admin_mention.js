import {removeGenerique} from "./app_admin_fonction";

$(document).ready(function(){
    const confirm_delete = ".confirm-delete";
    const modal = ".modal_effacer";

    $(document).on("click",confirm_delete,async function () {
        await removeGenerique(modal,$("#id").val(),"admin_mention_delete");
    });
})