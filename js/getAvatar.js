{
    let avatar = document.querySelector('input[name="avatar"');
    let avatarPath = document.querySelector('input[name="avatar_path"');
    avatar.addEventListener('change', async function (event) {
        if (this.files && this.files.length > 0) {
            let image = this.files[0];
            const formData = new FormData();
            formData.append('avatar', image);
            
            try {
                let response = await fetch('/api/users/avatar', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();
                console.log(data);
                avatarPath.value = data['redirect'];
                console.log(avatarPath);
            } catch (error) {
                console.error('Ошибка запроса:', error);
            }
        }
    })
}