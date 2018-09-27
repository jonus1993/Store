@extends('layouts.master')
@section('title')
NBP by VUE
@endsection
@section('styles')
<style>
[v-cloak] {
  display: none;
}
</style>
@endsection
@section('content')

<div v-cloak id="Itemlist">
    <h1>Waluty</h1>
    <section v-if="errored">
        <p>We're sorry, we're not able to retrieve this information at the moment, please try back later</p>
    </section>

    <section v-else>
        <div v-if="loading">Loading...</div>

        <table class="table table-active table-bordered" id="items-table">
            <thead>
                <tr>
                    <th>currency</th>
                    <th>code</th>
                    <th>mid</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in items">

                    <td>@{{ item.currency }}</td>
                    <td>@{{ item.code }}</td>
                    <td>@{{ item.mid | currencydecimal }}</td>
                </tr>
            </tbody>
        </table>
    </section>
</div>

@stop

@push('scripts')


<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>



<script>
    $(document).ready(function() {

        var ItemsVue = new Vue({
            el: '#Itemlist',
            data: {
                items: null,
                loading: true,
                errored: false
            },
            filters: {
                currencydecimal(value) {
                    return value.toFixed(2)
                }
            },
            mounted() {
                axios
                    .get('http://api.nbp.pl/api/exchangerates/tables/A/?format=json')
                    .then(response => {
                        this.items = response.data[0].rates
                    })
                    .catch(error => {
                        console.log(error)
                        this.errored = true
                    })
                    .finally(() => this.loading = false)
            }
        });  

    });
  

</script>
@endpush
