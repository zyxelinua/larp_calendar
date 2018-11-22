"use strict";

var margin = {top: 20, right: 20, bottom: 30, left: 20};

var width = $('#wrapper-main').width() - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

var svg = d3.select('#wrapper-main')
    .append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
    .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

$('#wrapper-main').css("height", height + margin.top + margin.bottom)

// Transpose the data into layers
var dataset = d3.layout.stack()(["score", "tick"].map(function(layer) {
    return data.map(function(d) {
        return {x: d['cat'], y: +d[layer], z: d['tooltip']};
    });
}));

// Set x, y and colors
var x = d3.scale.ordinal()
    .domain(dataset[0].map(function(d) { return d.x; }))
    .rangeRoundBands([10, width-10], 0.8);

var y = d3.scale.linear()
    .domain([0, 5])
    .range([height, 0]);

var colors = ['rgba(255, 0, 0, 0)', "#00005a"];


// Define and draw axes
var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left")
    .tickValues([1, 2, 3, 4, 5])
    .tickSize(-width, 0, 0)
    .tickFormat( function(d) { return d } );

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom")
    .tickSize(-height, 0, 0)

svg.append("g")
    .attr("class", "y axis")
    .attr('id','yaxis')
    .call(yAxis);

svg.append("g")
    .attr("class", "x axis")
    .attr("transform", "translate(0," + height + ")")
    .call(xAxis)
    .selectAll(".tick text")
        .call(wrap, x.rangeBand());

// Create groups for each series, rects for each segment
var groups = svg.selectAll("g.cost")
    .data(dataset)
    .enter().append("g")
    .attr("class", "cost")
    .style("fill", function(d, i) { return colors[i]; });

var rect = groups.selectAll("rect")
    .data(function(d) { return d; })
    .enter()
    .append("rect")
    .attr("x", function(d) { return x(d.x); })
    .attr("y", function(d) { return y(d.y0 + d.y); })
    .attr("height", function(d) { return y(d.y0) - y(d.y0 + d.y); })
    .attr("width", x.rangeBand())
    .on("mouseover", function() { tooltip.css("display", 'block'); })
    .on("mouseout", function() { tooltip.css("display", "none"); })
    .on("mousemove", function(d) {
        var xPosition = d3.mouse(this)[0] - 170;
        var yPosition = d3.mouse(this)[1] - 450;
        tooltip
            .css('left', xPosition)
            .css('top', yPosition)
            .text(d.z)
    });

// Prep the tooltip bits, initial display is hidden
$('#wrapper-main').append('<div id="mytooltip"></div>')
var tooltip = $('#mytooltip')
    .css('display', 'none')
    .css('position', 'relative')
    .css('border', '1px solid black')
    .css('border-radius', '5px')
    .css('background-color', 'white')
    .css('width', '360px')
    .css('padding', '10px 10px 10px 10px')


function wrap(text, width) {
    text.each(function() {
        var text = d3.select(this),
            words = text.text().split(/\s+/).reverse(),
            word,
            line = [],
            lineNumber = 0,
            lineHeight = 1.1, // ems
            y = text.attr("y"),
            dy = parseFloat(text.attr("dy")),
            tspan = text.text(null).append("tspan").attr("x", 0).attr("y", y).attr("dy", dy + "em");
        while (word = words.pop()) {
            line.push(word);
            tspan.text(line.join(" "));
            if (tspan.node().getComputedTextLength() > width) {
                line.pop();
                tspan.text(line.join(" "));
                line = [word];
                tspan = text.append("tspan").attr("x", 0).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
            }
        }
    });
}

