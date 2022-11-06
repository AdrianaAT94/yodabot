<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yodabot</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-4 mb-4">
        <div id="chat">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-8 mx-auto">
                    <div id="conver" class="text-justify">
                        <ul>
                            <li v-for="msg in msgList">
                                <span v-if="msg.bot" class="font-weight-bold mr-1">YodaBot:</span>
                                <span v-else class="font-weight-bold mr-1">Me:</span> 
                                <span v-html="msg.content">{{msg.content}} </span>
                            </li>
                        </ul>
                        <div v-show="writing" class="font-italic"> YodaBot is writing... </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-8 mx-auto">
                    <form class="navbar-form">
                        <div class="input-group">
                            <input type="text" class="form-control mr-1" placeholder="Write a message" v-model="nMsg">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-outline-secondary" @click.prevent="userMsg">Send!</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-4 col-sm-4 col-lg-4 mx-auto text-center mt-4">
                    <button type="submit" class="btn btn-outline-secondary" @click.prevent="deleteHistorial">Limpiar historial</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.22/vue.min.js"></script>
    <script src="js/app.js"></script>
</body>
</html>