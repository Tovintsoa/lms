import Axios from "axios";

export async  function showDetailUser(event,modal,origin){
    let route = '';
    switch (origin) {
        case 'admin':
            route = "admin_admin_show";
            break;
        case 'prof':
            route = "admin_prof_show";
            break;
        case 'etudiant':
            route = "admin_etudiant_show";
            break;
    }
    let ret = await axios.get(Routing.generate(route,{
        user: $(event.target).data("user")
    }));
    $(modal).html(ret.data);
    $(modal).modal();
}
export async function askRemoveUser(event,modal,origin){
    $("#userid").val($(event).data("user"));
    $("#origin").val($(event).data("origin"));
    $(modal).modal();
}
export async function removeUser(userid,modal,origin){
    let route = '';
    switch (origin) {
        case 'admin':
            route = "admin_admin_delete";
            break;
        case 'prof':
            route = "admin_prof_delete";
            break;
        case 'etudiant':
            route = "admin_etudiant_delete";
            break;
    }
    let ret = await axios.get(Routing.generate(route,{
        user: userid
    }));
    $(modal).modal("hide");
    window.location.reload();
}

export function askRemoveGenerique(val,modal){
    $("#id").val($(val).data("id"));
    $(modal).modal();
}
export async function removeGenerique(modal,id,route){
    await axios.get(Routing.generate(route,{
        id: id
    }));
    $(modal).modal("hide");
    window.location.reload();
}

export async function showMatiereByClass() {
    await axios.get('',{

    });
}