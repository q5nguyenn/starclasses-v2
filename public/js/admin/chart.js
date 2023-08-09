//Chart 1
var xValues = ["Ngoại ngữ", "Marketing", "Design", "Sales", "LifeStyle"];
var yValues = [55, 49, 44, 24, 15];
var barColors = [
	"#ad5df0",
	"rgb(236, 42, 237)",
	"#ff5a83",
	"#00cf93",
	"rgb(75, 161, 252)",
];

new Chart("myChart", {
	type: "pie",
	data: {
		labels: xValues,
		datasets: [
			{
				backgroundColor: barColors,
				data: yValues,
			},
		],
	},
	options: {
		title: {
			display: true,
			text: "Phần trăm các khoa",
		},
	},
});

// Chart 2
var xValues = [
	"Tiếng anh",
	"Guitar trong 30 ngày",
	"Kỹ năng sống",
	"LOL những điều chưa biết",
	"Javascrip",
];
var yValues = [55, 49, 44, 24, 15];
var barColors = [
	"rgb(75, 161, 252)",
	"rgb(236, 42, 237)",
	"#ad5df0",
	"#ff5a83",
	"#00cf93",
];

new Chart("myChart2", {
	type: "bar",
	data: {
		labels: xValues,
		datasets: [
			{
				backgroundColor: barColors,
				data: yValues,
			},
		],
	},
	options: {
		legend: { display: false },
		title: {
			display: true,
			text: "Các khoá học đông học viên nhất",
		},
	},
});

//Chart 3
const xValues3 = [50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150];
const yValues3 = [7, 8, 8, 9, 9, 9, 10, 11, 14, 14, 15];

new Chart("myChart3", {
	type: "line",
	data: {
		labels: xValues3,
		datasets: [
			{
				fill: false,
				lineTension: 0,
				backgroundColor: "rgb(75, 161, 252)",
				borderColor: "rgba(75, 161, 252, 0.1)",
				data: yValues3,
			},
		],
	},
	options: {
		legend: { display: false },
		title: {
			display: true,
			text: "Thống kê số lượng học viên theo tháng",
		},
		scales: {
			yAxes: [{ ticks: { min: 6, max: 16 } }],
		},
	},
});

//Chart 4
const xValues4 = [100, 200, 300, 400, 500, 600, 700, 800, 900, 1000];

new Chart("myChart4", {
	type: "line",
	data: {
		labels: xValues4,
		datasets: [{
			data: [860, 1140, 1060, 1060, 1070, 1110, 1330, 2210, 7830, 2478],
			borderColor: "rgb(255, 90, 131)",
			fill: false
		}, {
			data: [1600, 1700, 1700, 1900, 2000, 2700, 4000, 5000, 6000, 7000],
			borderColor: "rgb(0, 207, 147)",
			fill: false
		}, {
			data: [300, 700, 2000, 5000, 6000, 4000, 2000, 1000, 200, 100],
			borderColor: "rgb(75, 161, 252)",
			fill: false
		}]
	},
	options: {
		legend: { display: false },
		title: {
			display: true,
			text: "Thống kê số học viên 3 khoá học hot nhất",
		},
	}
});