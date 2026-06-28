{
    document.querySelector('.user-form').addEventListener('submit', async function (event) {
        event.preventDefault();

        const formData = new FormData(this);
        const dataObj = {};

        formData.forEach((value, key) => {
            dataObj[key] = value;
        });

        let dataJson = JSON.stringify(dataObj);
        console.log(dataJson);
        
        try {
            let response = await fetch('index.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json; charset=UTF-8'
                },
                body: dataJson
            });

            let data = await response.json();
            if (data.redirect) {
                window.location.href = data.redirect;
            }
        } catch (error) {
            console.error('Ошибка запроса:', error);
        }
    })
}