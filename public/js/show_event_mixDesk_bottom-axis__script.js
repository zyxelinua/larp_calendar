"use strict";

var margin = {top: 30, right: 20, bottom: 100, left: 20};

var width = $('#wrapper-bottom-axis').width() - margin.left - margin.right,
    height = 100 - margin.top - margin.bottom;

var svg_bottom = d3.select('#wrapper-bottom-axis')
    .append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
    .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

var x_bottom = d3.scale.ordinal()
    .domain(x_bottom_axis_list)
    .rangeRoundBands([10, width-10], 0.8);

var xAxisBottom = d3.svg.axis()
    .scale(x_bottom)
    .orient("bottom")
    .tickSize(0, 0, 0)

svg_bottom.append("g")
    .attr("class", "x axis")
    .attr('id','xaxis')
    .attr("transform", "translate(0," + height + ")")
    .call(xAxisBottom)
    .selectAll(".tick text")
        .call(wrap, x.rangeBand());
