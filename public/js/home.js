"use strict";

class Home {

    static TwUid;
    static fbId;
    static version = {
        hour: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
        week: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        month: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    }

    constructor() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        this.bindEvenet();
    }

    bindEvenet() {
        $('.show-items').click( ()=>{
            $('.graphics').css('display','block')
            $('.form').css('display','none')
        } )
        $('.secondary-item').click(function() {
            $('.graphics').css('display','block')
            $('.form').css('display','none')
            switch ($(this).data('type')) {
                case 'tw-secondary':
                    Home.getTwitterData(this);
                    break;
                case 'fb-secondary':
                    // Home.getFacebookData(this);
                    break;
            }
        })
        $('.page-analytics').click(function() {
             $('.graphics').css('display','block')
            $('.form').css('display','none')
            $('.third-items').slideToggle()
        })
        $('.facebook-data').click(function() {
             $('.graphics').css('display','block')
            $('.form').css('display','none')
            Home.getFacebookData(this)
        })
        $('.graph-type').click(function(e) {
            // e.stopPropagation()
            // e.preventDefault()
            if (this.getAttribute('social') == 'fb') {
                document.getElementById('activeGraphFb').removeAttribute('id');
                this.id = 'activeGraphFb';
                Home.getFacebookData(document.querySelectorAll('li.active[data-type="fb-secondary"][name="messages"]')[0]);
            } else {
                $('.statistic[data-type=' + $(this).attr('class') + ']').css('display', 'flex');
                // .css('display','flex');
                document.getElementById('activeGraphTw').removeAttribute('id');
                this.id = 'activeGraphTw';
                Home.getTwitterData(document.querySelector('[data-type="tw-secondary"]'));
                // document.getElementById('activeGraphTw').click();
            }
        })
        $('.fb-page-name').click(function() {
        })

        $('.graph-post-type').click(function(e) {

            $('.graphics').css('display','block')
            $('.form').css('display','none')
            document.getElementById('activeGraphTwPost').removeAttribute('id');
            this.id = 'activeGraphTwPost';
            $('.statistic[data-type=' + $(this).attr('class') + ']').css('display', 'flex');
            Home.getTwitterData(document.querySelector('li[data-type="tw-secondary"][name="posts"]'))
        })

        $(document).on('click', '.show-items', function() {
             $('.graphics').css('display','block')
            $('.form').css('display','none')
            if ($('.dashboard-item').hasClass('for-after')) {
                $('.dashboard-item').removeClass('for-after').addClass('for-after1')
            } else {
                $('.dashboard-item').removeClass('for-after1').addClass('for-after')
            }
            $('.base-items').slideToggle();
        })
        $(document).on('click','.upload-form',(e)=> {
            e.stopPropagation()
            e.preventDefault()
            $('.graphics').css('display','none')
            $('.form').css('display','flex')
        })
        $(document).on('click','.open-file', ()=>{
            $("#zip-file").click()
        })
    }

    static getTwitterData(element) {
        $.ajax({
            method: 'POST',
            url: '/getTwData',
            data: {
                type: $(element).attr('name')
            },
            success: function(r) {
                Home.TwUid = JSON.parse(r).userId;
                if (JSON.parse(r).type == 'message') {
                    // Home.getStatistics(JSON.parse(r).data)
                    let hour = Home.twAction(JSON.parse(r).data, 'hour')
                    let day = Home.twAction(JSON.parse(r).data, 'week')
                    let month = Home.twAction(JSON.parse(r).data, 'month')
                    let maxHour = Math.max(...hour[2].data)
                    let maxDay = Math.max(...day[2].data)
                    let maxMonth = Math.max(...month[2].data)
                    let maxHourName = Home.version['hour'][hour[2].data.indexOf(maxHour)]
                    let maxDayName = Home.version['week'][day[2].data.indexOf(maxDay)]
                    let maxMonthName = Home.version['month'][month[2].data.indexOf(maxMonth)]

                    let hourInner = "Hour:<strong>" + maxHourName + ":00</strong><br>Count:<strong>" + maxHour + "</strong>"
                    let dayInner = "Day:<strong>" + maxDayName + "</strong><br>Count:<strong>" + maxDay + "</strong>"
                    let monthInner = "Hour:<strong>" + maxMonthName + "</strong><br>Count:<strong>" + maxMonth + "</strong>"
                    $('.message-type-hour').html(hourInner)
                    $('.message-type-day').html(dayInner)
                    $('.message-type-month').html(monthInner)
                    Home.setMessageGraph(
                        Home.twAction(JSON.parse(r).data, document.getElementById('activeGraphTw').getAttribute('type')), {
                            container: 'twContainer',
                            header: 'Twitter messages analytics',
                            type: document.getElementById('activeGraphTw').getAttribute('type')
                        }
                    )
                } else {
                    let hour = Home.twPosts(JSON.parse(r), 'hour')
                    let day = Home.twPosts(JSON.parse(r), 'week')
                    let month = Home.twPosts(JSON.parse(r), 'month')
                    let maxHour = Math.max(...hour[0].data)
                    let maxDay = Math.max(...day[0].data)
                    let maxMonth = Math.max(...month[0].data)
                    let maxHourName = Home.version['hour'][hour[0].data.indexOf(maxHour)]
                    let maxDayName = Home.version['week'][day[0].data.indexOf(maxDay)]
                    let maxMonthName = Home.version['month'][month[0].data.indexOf(maxMonth)]
                    let hourInner = "Hour:<strong>" + maxHourName + ":00</strong><br>Count:<strong>" + maxHour + "</strong>"
                    let dayInner = "Day:<strong>" + maxDayName + "</strong><br>Count:<strong>" + maxDay + "</strong>"
                    let monthInner = "Hour:<strong>" + maxMonthName + "</strong><br>Count:<strong>" + maxMonth + "</strong>"
                    $('.post-type-hour').html(hourInner)
                    $('.post-type-day').html(dayInner)
                    $('.post-type-month').html(monthInner)
                    Home.setMessageGraph(
                        Home.twPosts(JSON.parse(r)), {
                            container: 'twPostContainer',
                            header: 'Twitter posts analytics',
                            type: document.getElementById('activeGraphTwPost').getAttribute('type')
                        }
                    )
                }
            }
        })
    }
    static twPosts(res, type = false) {
        if (!type) {
            var type = document.getElementById('activeGraphTwPost').getAttribute('type');
        }
        return [{
            name: 'Posts',
            data: Home.getPData(res.posts, type)
        }, {
            name: 'Retweets',
            data: Home.getPData(res.retweets, type)
        }, {
            name: 'Mentions',
            data: Home.getPData(res.mentions, type)
        }];
    }

    static getPData(res, type) {
        var date, arr = [];
        res.forEach(e => {
            date = new Date(e.created_at * 1000);
            date = Home.getDate(date, type);
            arr[date] ? arr[date]++ : arr[date] = 1;
        })

        return Home.getDateArray(arr, type);
    }

    static getDateArray(arr, ver) {
        for (let i = 0; i < Home.version[ver].length; i++) {
            if (!arr[i]) {
                arr[i] = 0;
            }
        }

        return arr;
    }

    static getDate(date, ver) {
        switch (ver) {
            case 'hour':
                date = date.getHours();
                break;
            case 'week':
                date = date.getDay();
                break;
            case 'month':
                date = date.getMonth();
                break;
        }

        return date
    }

    static twAction(res, ver, social = 'tw') {
        return [{
            name: 'Sent',
            data: Home.getData(res, ver, 'sent', social)
        }, {
            name: 'Received',
            data: Home.getData(res, ver, 'received', social)
        }, {
            name: 'Sent and received',
            data: Home.getData(res, ver, 'sr', social)
        }];
    }

    static getData(res, ver, type, social) {
        var date, arr = [],
            cond;
        res.forEach(e => {
            date = new Date(social == 'tw' ? +e.created_timestamp : +e.created_timestamp * 1000);
            if (social == 'tw') {
                cond = type == 'sent' ? Home.TwUid == e.sender : type == 'received' ? Home.TwUid == e.recipient : true;
            } else {
                cond = type == 'sent' ? Home.fbId == e.sender : type == 'received' ? Home.fbId == e.recipient : true;
            }
            if (cond) {
                date = Home.getDate(date, ver);
                arr[date] ? arr[date]++ : arr[date] = 1;
            }
        })

        return Home.getDateArray(arr, ver)
    }

    // static setDates(data)
    // {
    //     let arr = [];
    //     let ver = 'month';
    //     data.forEach(e =>{
    //         let date = +e.created_time*1000;
    //         date = new Date( date );
    //         switch(ver) {
    //             case 'hour':
    //                 date = date.getHours();
    //             break;
    //             case 'week':
    //                 date = date.getDay();
    //             break;
    //             case 'month':
    //                 date = date.getMonth();
    //             break;
    //         }

    //         arr[date] ? arr[date]++ : arr[date] = 1;
    //     })
    // }

    static getFacebookData(element) {
        $.ajax({
            method: 'POST',
            url: '/getFbData',
            data: {
                id: $(element).attr('data-id'),
                type: $(element).attr('name')
            },
            success: function(r) {
                let response = JSON.parse(r);
                if (response.success) {
                    Home.fbId = response.pageId;
                    var data = Home.twAction(JSON.parse(r).data, document.getElementById('activeGraphFb').getAttribute('type'), 'fb');
                    Home.setMessageGraph(data, {
                        container: 'fbContainer',
                        header: 'Facebook messages analytics',
                        type: document.getElementById('activeGraphFb').getAttribute('type')
                    })
                } else {
                    // show error
                }
            }
        })
    }

    static setMessageGraph(data, info) {
        var ctx      = $('#'+info.container) 
        var dataSets = Home.setCustomChartData(data)
        console.log('dataSets',dataSets)
        
        var chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'bottom',
            },
            hover: {
                mode: 'label'
            },
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        color: "#f3f3f3",
                        drawTicks: false,
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Month'
                    },
                    ticks: {
                        padding: 15
                    }
                }],
                yAxes: [{
                    display: true,
                    gridLines: {
                        color: "#f3f3f3",
                        drawTicks: false,
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Value'
                    },
                    ticks: {
                        padding: 15
                    }
                }]
            },
            title: {
                display: true,
                text: info.header
            }
        };
        var chartData = {
            labels: Home.version[info.type],
            datasets:dataSets
        };
        var config = {
            type: 'line',
            options: chartOptions,
            data: chartData
        };
        var lineChart = new Chart(ctx, config);
    }

    static setCustomChartData(data)
    {
        var colors_array = ['#757ea7', '#745e75', '#267b52', '#5b6359', '#ffa000', '#33efac', '#ff4961'];
        var dataSets = [];
        for (var i = 0; i < data.length; i++) {
            let set = {
                label: data[i].name,
                data: data[i].data,
                fill: false,
                borderColor: colors_array[i],
                pointBorderColor: colors_array[i],
                pointBackgroundColor: "#FFF",
                pointBorderWidth: 1,
                pointHoverBorderWidth: 1,
                pointRadius: 3,
            }
            dataSets.push(set);

        }
        return dataSets
    }
}

document.addEventListener("DOMContentLoaded", function() {
    const home = new Home();
})