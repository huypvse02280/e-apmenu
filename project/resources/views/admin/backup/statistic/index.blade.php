@extends('layouts.base')
@section('title', '追加')

@section('page-content')
    <div class="row">
		<div class="col-md-12">
			<div class="x_panel">
	          <div class="x_title">
	            <h2>追加</h2>
	            <ul class="nav navbar-right panel_toolbox" style="min-width: auto;">
	              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	              </li>
	              <li><a class="close-link"><i class="fa fa-close"></i></a>
	              </li>
	            </ul>
	            <div class="clearfix"></div>
	          </div>
				<div class="x_content">
					<div class="row">
						{{ Form::open(['route' => 'admin.pias.statistic', 'method' => 'GET', 'class' => 'frm-filter', 'onSubmit' => 'renderStatistic(); return false;'])}}
						<div class="form-group col-md-3">
                            {{ Form::label('search-date', '日付を選択します。') }}
                            {{ Form::text('searchDay', isset($_GET['searchDay']) ? $_GET['searchDay'] : null, ['id' => 'search-statistic', 'class' => 'form-control input-text', 'placeholder' => '日付を選択してください。']) }}
                        </div>
                        
                        <div class="form-group pull-right">
                            {!! html_entity_decode(Form::button('<i class="fa fa-search">&nbsp;</i> 検索', ['type' => 'submit','class' => 'btn btn-success input-submit'])) !!}
                            <a href="javascript:void(0)" class="btn btn-default input-clear input-submit" style="margin-right:10px;"><i class="fa fa-remove">&nbsp;</i>Clear</a>

                        </div>
                        {!! Form::close() !!}
					</div>
				</div>
			</div>
			<div class="x_panel">
	          <div class="x_title">
	            <h2>データ</h2>
	            <ul class="nav navbar-right panel_toolbox" style="min-width: auto;">
	              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	              </li>
	              <li><a class="close-link"><i class="fa fa-close"></i></a>
	              </li>
	            </ul>
	            <div class="clearfix"></div>
	          </div>
				<div class="x_content">
					<div class="overflow" style="position: relative; min-height: 100px;">
                        <div id="table-statistic"></div>
                        <div class="loading"></div>
                    </div>
				</div>
			</div>
		</div>
	</div>
@stop()

@section('page-script')
<script type="text/javascript">

	function zoom(value) {
		$('#table-statistic table').css({
			transformOrigin: 'top left',
			transform: 'scale(' + value + ')',
		});
		// $('#table-statistic').css({
		// 	width: $('#table-statistic table').outerWidth() * value + 10,
		// 	height: $('#table-statistic table').outerHeight() * value + 10,
		// 	overflow: 'auto'
		// })
	}

	function zoomIn(){
		zoom(Math.min(2, getScaleDegrees($('#table-statistic table').css('transform')) + 0.1));
	}

	function zoomOut(){
		zoom(Math.min(2, getScaleDegrees($('#table-statistic table').css('transform')) - 0.1));
	}

	function zoomReset(){
		zoom(1);
	}

	function zoomFit(){
		var tableWidth = parseFloat($('#table-statistic table').outerWidth());// * parseFloat($('#table-statistic table').css('zoom'));
		var containerWidth = parseFloat($('#table-statistic').outerWidth());
		zoom(containerWidth/tableWidth);
	}

	parseMatrix = function(_str) {
	    return _str.replace(/^matrix(3d)?\((.*)\)$/,'$2').split(/, /);
	}

    getScaleDegrees = function(matrix) {
	    var matrix = parseMatrix(matrix),
	        scale = 1;

	    if(matrix[0] !== 'none') {
	        var a = matrix[0],
	            b = matrix[1],
	            d = 10;
	        scale = Math.round( Math.sqrt( a*a + b*b ) * d ) / d;
	    }

	    return scale;
	}

	function renderStatistic() {
		$('#table-statistic').css({
			height: 'auto'
		}).html('');
		$('.loading').show();
		var endPoint = '/api/statistic';
		var keyWord = $('input[name=searchDay]').val();
		$.ajax({
			url : url(endPoint),
			data : {'searchDay':keyWord},
			success : function(data) {
				$('.loading').fadeOut();
				if (!data) {
					$('#table-statistic').html('<div class= "alert alert-danger">何もデータが見つかりませんでした</div>');
					return;
				}
				var d = data[Object.keys(data)[0]].data;
				var currentDate = moment(d[Object.keys(d)[0]].history[0].start).format('Y-MM-D');
				$('#table-statistic').parents('.overflow').parent().find("#zoom-control-panel").remove();
				$('#table-statistic').parents('.overflow').before(
					$('<div class="row" id="zoom-control-panel"/>').append(
						$('<div class="col-md-12"/>').append(
							$('<h4/>')
							.html(currentDate + 'の統計データ')
							.append(
								$('<div/>')
								.addClass('pull-right')
								.append($('<button/>').addClass('btn btn-default').html('<i class="fa fa-search-minus"></i>').click(zoomOut))
								.append($('<button/>').addClass('btn btn-default').html('<i class="fa fa-search-plus"></i>').click(zoomIn))
								.append($('<button/>').addClass('btn btn-default').html('<i class="fa fa-refresh"></i>').click(zoomReset))
								.append($('<button/>').addClass('btn btn-default').html('<i class="fa fa-exchange"></i>').click(zoomFit))
							)
						)
					)
				);
				$('#table-statistic')
				.html('')
				.append(renderTableStatistic(data, 80));
				$('#table-statistic table').css({
					borderWidth: 2
				})
			}
		});

		return false;
	}

	function renderTableStatistic(data, chartCellWidth, callback) {
		colSum = {};
		var finalSum = 0;
		var tableHead =
		[
			'<thead>',
	            '<tr>',
	                '<th class="td-left td-inline">区分</th>',
	                '<th class="td-left td-inline">氏名</th>',
	                '<th class="td-left td-inline">端末（MACアドレス）</th>',
	                '<th class="td-right td-inline td-time-chart">14:00</th>',
	                '<th class="td-right td-inline td-time-chart">15:00</th>',
	                '<th class="td-right td-inline td-time-chart">16:00</th>',
	                '<th class="td-right td-inline td-time-chart">17:00</th>',
	                '<th class="td-right td-inline td-time-chart">18:00</th>',
	                '<th class="td-right td-inline td-time-chart">19:00</th>',
	                '<th class="td-right td-inline td-time-chart">20:00</th>',
	                '<th class="td-right td-inline td-time-chart">21:00</th>',
	                '<th class="td-right td-inline td-time-chart">22:00</th>',
	                '<th class="td-right td-inline td-time-chart">23:00</th>',
	                '<th class="td-right td-inline td-time-chart">00:00</th>',
	                '<th class="td-right td-inline td-time-chart">01:00</th>',
	                '<th class="td-right td-inline td-time-chart">02:00</th>',
	                '<th class="td-right td-inline td-time-chart">03:00</th>',
	                '<th class="td-right td-inline td-time-chart">04:00</th>',
	                '<th class="td-right td-inline td-time-chart">05:00</th>',
	                '<th class="td-right td-inline td-time-chart">06:00</th>',
	                '<th class="td-right td-inline td-time-chart">07:00</th>',
	                '<th class="td-right td-inline td-time-chart">08:00</th>',
	                '<th class="td-right td-inline td-time-chart">09:00</th>',
	                '<th class="td-right td-inline td-time-chart">10:00</th>',
	                '<th class="td-right td-inline td-time-chart">11:00</th>',
	                '<th class="td-right td-inline td-time-chart">12:00</th>',
	                '<th class="td-right td-inline td-time-chart">13:00</th>',
	                '<th class="td-right td-inline">アクセス時間（分）</th>',
	            '</tr>',
	        '</thead>'
        ].join('');

        function processHistory(data) {
        	var result = {};
        	for(var i in data) {
        		var dateStr = moment(data[i].start).format('Y-M-D');
        		var dateEStr = moment(data[i].end).format('Y-M-D');
				var dd = moment(data[i].end).diff(data[i].start, 'days');
				if(dd > 0) {
					data[i].end = [dateStr, ' 23:59:59'].join('');
				}
        		var eh = moment(data[i].end).hours();
        		var sh = moment(data[i].start).hours();
        		var eh = moment(data[i].end).hours();
        		var em = moment(data[i].end).minutes();
        		var es = moment(data[i].end).seconds();

        		

        		var shTimeStr = moment(data[i].start).format('H:m:s');
        		var ehTimeStr = moment(data[i].end).format('H:m:s');

        		if(eh == sh || em + es == 0) {
        			if(!result[eh]) {
        				result[eh] = [];
        			}
        			result[sh].push(data[i]);
        		} else if(em + es > 0){
        			for(var j = sh; j <= eh; j++) {
        				if(!result[j]) {
	        				result[j] = [];
	        			}
	        			if(j == sh) {
	        				result[j].push({
	        					start: data[i].start,
	        					end: [dateStr, ' ', j + 1, ':00:00'].join('')
	        				});
	        			} else if(j == eh){
	        				result[j].push({
	        					start: [dateStr, ' ', j, ':00:00'].join(''),
	        					end: data[i].end
	        				});
	        			} else {
	        				result[j].push({
	        					start: [dateStr, ' ', j, ':00:00'].join(''),
	        					end: [dateStr, ' ', j + 1, ':00:00'].join('')
	        				});
	        			}
        			}
        		}
        	}
        	// console.log(result)
        	return result;
        }

        function renderRows(data){
        	var result = [];
        	for(var tid in data) {
        		var idxx = 0;
	        	for(var x in data[tid].data) {
	        		var extraStyle = idxx == 0 ? 'border-top: 2px solid #ddd;padding:4px' : '';
	        		var row =
					[
			            '<tr ', 'style="',extraStyle,'"','>',
			                '<td ', 'style="',extraStyle,'border-left:2px solid #ddd;"',' class="td-left td-inline">', data[tid].team_name , '</td>',
			                '<td ', 'style="',extraStyle,'"',' class="td-left td-inline">', data[tid].data[x].user_name , '</td>',
			                '<td ', 'style="',extraStyle,'"',' class="td-left td-inline">', data[tid].data[x].mac_address ,'</td>'
			        ];
			        var rowSum = 0;
			        data[tid].data[x].history = processHistory(data[tid].data[x].history);
			        for(var i = 0; i < 24; i++) {
			        	var idx = 13 + i;
			        	idx = idx > 23 ? idx - 24 : idx;
			        	row.push('<td ', 'style="',extraStyle,'"',' class="td-right td-inline td-time-chart">' + renderChart(idx, data[tid].data[x].history[idx], data[tid].color) + '</td>');
			        	for(var j in data[tid].data[x].history[idx]) {
			        		var sum = moment(data[tid].data[x].history[idx][j].end, 'YYYY-MM-DD HH:mm:ss').diff(moment(data[tid].data[x].history[idx][j].start, 'YYYY-MM-DD HH:mm:ss'), 'seconds');
			        		// console.log(data[tid].data[x].history[idx][j].end + '-' + data[tid].data[x].history[idx][j].start + '=' +sum)
			        		if(!colSum[idx]) {
			        			colSum[idx] = 0;
			        		}
			        		colSum[idx] += sum;
			        		rowSum += sum;
			        	}
			        }
			        extraStyle += ';background: #ebebeb;border-right-width:2px';
			        row.push('<td ', 'style="',extraStyle,'"',' class="td-right td-inline">' + Math.round(rowSum / 60 * 100)/100 +'</td></tr>');
			        result.push(row.join(''));
			        idxx ++;
	        	}
        	}
	        
	        return result.join('');
	    }

	    function renderChart(index, data, color) {
	    	var chart = $('<div class="wl-chart"/>');
	    	var percentPerSec = 100/(60 * 60);
	    	for(var i in data) {
	    		var x = moment(data[i].start, 'YYYY-MM-DD HH:mm:ss').diff(
			    			moment(
			    				moment(data[i].start, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD'), 'YYYY-MM-DD'
			    			).add(index, 'hours'), 
			    			'seconds'
	    			);
	    		var left = percentPerSec * x;
	    		var duration = moment(data[i].end, 'YYYY-MM-DD HH:mm:ss').diff(moment(data[i].start, 'YYYY-MM-DD HH:mm:ss'), 'seconds');
	    		var width = duration * percentPerSec;
	    		var el = $('<div/>').addClass('chart-el').css({
		    		left: left + '%',
		    		width: width + '%',
		    		background: color != null ? color.split(',')[0] : '#CCC'
		    	})
	    		chart.append(el);
	    	}
	    	return chart[0].outerHTML;
	    }

	    function renderSummary() {
	    	var row =
			[
	            '<thead><tr style="background: #ebebeb">',
	                '<th style="border-top-width: 2px" class="td-left td-inline" colspan="3">接客合計（分）</th>'
	        ];
	        var sum = 0;
	        for(var i = 0; i < 24; i++) {
	        	var idx = 13 + i;
	        	idx = idx > 23 ? idx - 24 : idx;
	        	row.push('<th style="border-top-width: 2px" class="td-right td-inline td-time-chart">' + (colSum[idx] ? (Math.round(colSum[idx] / 60 * 100)/100) : '') + '</th>');
	        	sum += colSum[idx] || 0;
	        }
	        row.push('<th style="border-top-width: 2px" class="td-right td-inline">' + Math.round(sum / 60 * 100)/100 +'</th></tr></thead>')
	        return row.join('');
	    }

	    var rows = renderRows(data);

		var fullTable = $([
			'<table class="table table-striped table-bordered table-hover">',
			tableHead,
			'<tbody>',
			rows,
			renderSummary(),
			'</tbody>',
			'</table>',
		].join(''));

		$(fullTable).css({
			transformOrigin: 'top left',
			transform: 'scale(1)'
		})
		
		$(fullTable).find('.td-time-chart').css({
			minWidth: chartCellWidth
		})
		if(callback) {
			callback();
		}
		return fullTable[0].outerHTML;
	}
</script>
@endsection