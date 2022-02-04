require('./bootstrap');

function fetchJsonPost($datas){
    return {
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-Token": $('input[name="_token"]').val()
        },
        method: "post",
        body: JSON.stringify($datas)
        }
    }

function fetchPost($datas){
    return {
        headers: {
            "X-CSRF-Token": $('input[name="_token"]').val()
        },
        method: "post",
        body: JSON.stringify($datas)
    }
}

function fetchGet(){
    return{
        method: 'GET',
        headers:{
            "Content-Type": "application/json"
        }
    }
}
