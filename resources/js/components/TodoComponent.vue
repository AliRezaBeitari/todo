<template>
    <div v-if="!isDeleted" class="row justify-content-center">
        <div class="col-md-8 mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            Todo #{{ todo.id }}
                        </div>

                        <div class="col-md-6">
                            <button v-if="!isEditing" v-on:click="edit" type="button" class="btn btn-primary btn-sm float-right ml-2">Edit</button>
                            <button v-if="!isEditing" v-on:click="_delete" type="button" class="btn btn-danger btn-sm float-right ml-2">Delete</button>

                            <button v-if="!isEditing && !todo.is_completed" v-on:click="toggle" type="button" class="btn btn-success btn-sm float-right">Complete</button>
                            <button v-if="!isEditing && todo.is_completed" v-on:click="toggle" type="button" class="btn btn-secondary btn-sm float-right">Uncompleted</button>

                            <button v-if="isEditing" v-on:click="save" type="button" class="btn btn-success btn-sm float-right ml-2">Save</button>
                            <button v-if="isEditing" v-on:click="discard" type="button" class="btn btn-danger btn-sm float-right ml-2">Discard</button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <p v-if="!isEditing" class="m-0">{{ todo.text }}</p>

                    <div v-if="isEditing" class="form-group">
                        <input ref="newText" v-model="newText" type="text" class="form-control" placeholder="Enter your TODO here..." autofocus>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    const axios = require('axios');

    export default {
        props: [ 'todo' ],

        data: function () {
            return {
                isEditing: false,
                newText: '',
                isDeleted: false,
            };
        },

        methods: {
            edit: function () {
                this.isEditing = true;
            },

            toggle: function () {
                const data = {
                    is_completed: ! this.todo.is_completed,
                };

                const self = this;

                axios
                    .put(`/api/todo/${this.todo.id}`, data, this.$parent.config)
                    .then(res => {
                        self.todo.is_completed = ! self.todo.is_completed;
                        self.$forceUpdate();
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },

            _delete: function () {
                const self = this;

                axios
                    .delete(`/api/todo/${this.todo.id}`, this.$parent.config)
                    .then(res => {
                        self.isDeleted = true;
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },

            save: function () {
                const data = {
                    text: this.newText,
                };

                const self = this;

                axios
                    .put(`/api/todo/${this.todo.id}`, data, this.$parent.config)
                    .then(res => {
                        self.todo.text = self.newText;
                        self.isEditing = false;
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },

            discard: function () {
                this.newText = this.todo.text;
                this.isEditing = false;
            },
        },

        mounted() {
            this.newText = this.todo.text;
        }
    }
</script>