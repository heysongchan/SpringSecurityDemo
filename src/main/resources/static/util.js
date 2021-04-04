var merge = {
    field: "",
    index: 0,
    rowspan: 1
}

var data = [
    {
        id: "1", item1: "aa", item2: "bb", deviation: "aaa", detail: "aaa"
    },
    {
        id: "2", item1: "aa", item2: "ccc", deviation: "aaa", detail: "aaa"
    },
    {
        id: "3", item1: "d", item2: "cee", deviation: "aaa", detail: "aaa"
    },
    {
        id: "7", item1: "d", item2: "cee", deviation: "aaa", detail: "aaa"
    },
    {
        id: "8", item1: "d", item2: "cee", deviation: "aaa", detail: "aaa"
    },
    {
        id: "4", item1: "aa", item2: "ccc", deviation: "aaa", detail: "aaa"
    },
    {
        id: "5", item1: "aa", item2: "ccc", deviation: "aaa", detail: "aaa"
    },
    {
        id: "6", item1: "d", item2: "ccc", deviation: "aaa", detail: "aaa"
    },
];

var getMergeAndSetNo = function (data) {
    var tmp = {};
    var ret = [];
    var no = 0;
    var last;
    data.forEach(function (value, index) {
        if (value.item1 == last) {
            var v = tmp[value.item1];
            if (!v) {
                v = {}; tmp[value.item1] = v;
                v.field = 'item1';
            }
            if (v.index == undefined) {
                v.index = index - 1;
            }
            if (v.rowspan == undefined) {
                v.rowspan = 2;
            } else {
                v.rowspan += 1;
            }
        } else {
            for (var a in tmp) {
                ret.push(tmp[a]);
                var noo = {};
                Object.assign(noo, tmp[a]);
                noo.field = "no";
                ret.push(noo);
            }
            no++;
            tmp = {};
        }
        value.no = no;
        last = value.item1;
    });
    for (var a in tmp) {
        ret.push(tmp[a]);
    }
    tmp = {};
    console.log(ret);
    console.log(data);
}
getMergeAndSetNo(data);