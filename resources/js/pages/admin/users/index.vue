<template>Đây là quản lý Users</template>

<script>
export default {
    setup() {
        const getUsers = () => {
            axios
                .get("http://localhost:8000/api/users")
                .then(function (response) {
                    // handle success
                    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        };
        getUsers();
    },
};
</script>
