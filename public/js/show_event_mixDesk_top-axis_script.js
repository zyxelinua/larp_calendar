"use strict";

var margin = {top: 10, right: 20, bottom: 50, left: 20};

var width = $('#wrapper-top-axis').width() - margin.left - margin.right,
    height = 100 - margin.top - margin.bottom;

var svg_top = d3.select('#wrapper-top-axis')
    .append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
    .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

var x_top = d3.scale.ordinal()
    .domain(x_top_axis_list)
    .rangeRoundBands([10, width-10], 0.8);

var xAxisTop = d3.svg.axis()
    .scale(x_top)
    .orient("bottom")
    .tickSize(0, 0, 0)

svg_top.append("g")
    .attr("class", "x axis")
    .attr("transform", "translate(0," + height + ")")
    .call(xAxisTop)
    .selectAll(".tick text")
        .call(wrap, x.rangeBand());
