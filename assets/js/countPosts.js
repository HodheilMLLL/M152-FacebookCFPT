if (document.getElementById("countPosts") != null) {
    var requestOptions = {
        method: 'GET',
        redirect: 'follow'
    };
    fetch("index.php?uc=countPosts", requestOptions).then(function(response) {
            return response.json();
        })
        .then(function(myDatas) {
            document.getElementById("countPosts").innerText = myDatas;
        })

}