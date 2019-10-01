<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-8 mb-3">
                <button type="button" data-toggle="modal" class="btn btn-success float-right ml-2" data-target="#todoModal">Add New TODO</button>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="todoModal" role="dialog" aria-labelledby="todoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="todoModalLabel">New TODO</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <input v-model="newTodo.text" type="text" class="form-control" placeholder="Enter your TODO here...">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-on:click="createTodo" v-bind:disabled="newTodo.text === ''" type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="todos.length > 0">
            <todo v-for="t in todos" v-bind:key="t.id" v-bind:todo="t"></todo>
        </div>

        <div v-else>
            Empty
        </div>
    </div>
</template>

<script>
    const axios = require('axios');

    export default {
        props: [ 'token' ],

        data: function () {
            return {
                config: {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${this.token}`,
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                },
                todos: [],
                newTodo: {
                    text: '',
                },
            };
        },

        methods: {
            createTodo: function () {
                const data = {
                    text: this.newTodo.text,
                };

                const self = this;

                axios
                    .post('/api/todos', data, this.config)
                    .then(res => {
                        self.todos.unshift(res.data);
                        self.newTodo.text = '';
                        self.$forceUpdate();

                        $('#todoModal').modal('hide');
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
        },

        mounted() {
            const self = this;

            axios
                .get('/api/todos', this.config)
                .then(res => {
                    self.todos = res.data.data;
                })
                .catch(err => {
                    console.log(err);
                });
        },
    }
</script>