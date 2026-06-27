{
    document.querySelector('.user-form').addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(this);
        const dataObj = {};

        formData.forEach((value, key) => {
            dataObj[key] = value;
        });

        let dataJson = JSON.stringify(dataObj);
        console.log(dataJson);

        fetch('work_database.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json; charset=UTF-8'
            },
            body: dataJson
        })
        .then(response => response.json())
        .then(data=>{
            if (data.redirect) {
                window.location.href = data.redirect;
            }
        })
        .catch(error=>{
            console.error('Ошибка запроса:', error);
        })
    })
}