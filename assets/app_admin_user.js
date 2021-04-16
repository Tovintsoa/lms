import {showDetailUser,askRemoveUser,removeUser} from './app_admin_fonction';
$(document).ready(function(){
    const modal = ".bd-example-modal-lg";
    const modal_delete = ".bd-modal-delete";
    const btn_show_user = ".show-user";
    const btn_delete_user = ".delete-user";

    $(document).on("click",btn_show_user, async function(event){
        let origin = $(this).data("origin");
        await showDetailUser(event, modal, origin);
    });
    $(document).on("click",btn_delete_user,async function (event) {
        let origin = $(this).data("origin");
        await askRemoveUser(this, modal_delete, origin);
    });
    $(document).on("click",".confirm-delete",async function() {
        let origin = $("#origin").val();
        await removeUser($("#userid").val(),modal_delete,origin);
    });
});