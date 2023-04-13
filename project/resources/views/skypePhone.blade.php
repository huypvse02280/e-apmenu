@extends('layouts.base')
@section('title', 'skype電話')
<style type="text/css">
	.has-search .form-control-feedback {
		right: initial;
		left: 0;
		color: #ccc;
		margin-top:4px;
	}
	.has-search .form-control {
		padding-right: 12px;
		padding-left: 34px;
	}
	.user-item{
		height:50px;
		line-height:50px;
		background:#ededed;
		padding:0px 0px 0px 5px;
		border-bottom:1px solid rgba(167, 164, 167, 0.667);
	}
	.skype-icon{
		width:28px;
		height:28px;
	}
	.right{
		float:right;
		margin-top:8px;
	}
	.search-result{
		max-height:calc(100vh - 280px);
		overflow-y:scroll;
	}
	.container{
		margin:0px!important;
		padding:0px!important;
	}
</style>
@section('page-content')

<div class="row">
	<div x-data="componentSearchData()" x-init="init()" class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2 col-xs-12">
		<div class="form-group has-feedback has-search">
			<span class="glyphicon glyphicon-search form-control-feedback"></span>
			<input type="text" class="form-control" x-model.debounce.1000ms="searchName" placeholder="名前入力">
		</div>
		<div class="search-result">
			<template x-for="user in lstUserFilter" :key="user.user_id">
				<div class="user-item">
					<span x-text="user.name"></span>
					<a x-show="user.skype_id != null && user.skype_id != ''" class="btn btn-primary btn-xs right" x-bind:href="'skype:'+user.skype_id+'?call'">
						<img class="skype-icon" src="{{ asset('skype.svg') }}"/> 通話
					</a>
					<a x-show="user.phone != null && user.phone != ''" style="margin-right:15px;" class="btn btn-default btn-xs right" x-bind:href="'tel:'+user.phone">
						<img class="skype-icon" src="{{ asset('phone.svg') }}"/> 通話
					</a>
				</li>
			</template>
			{{-- <template x-if="lstUserFilter == null || lstUserFilter.length == 0">
				<div class="user-item">データがありません。</div>
			</template> --}}
		</div>
	</div>
</div>
<script>
	let componentSearchData = function(){
		return {
			searchName:'',
			lstUser:[],
			lstUserFilter:[],
			init(){
				let url = '{{ url('/') }}';
				let _this = this;
				fetch(url+'/api/user/all')
				.then(response => response.json())
				.then(response =>{
					this.lstUser = response.lstUser;
				});
				this.$watch('searchName', value=>{
					if(value.length > 0) {
						_this.lstUserFilter = _this.lstUser.filter(user => {
						return user.name.includes(value);
					});
					}
				})
			}
		}
	}
</script>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
@endsection
