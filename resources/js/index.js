var addTwoNumbers = function(l1, l2) {
    let arr1 = l1.reverse();
    let arr2 = l2.reverse();
    let arr3;

    let num1 = Number(arr1.join(''));
    let num2 = Number(arr2.join(''));

    let sum = num1 + num2;

    let finArr= sum.toString().split('').reverse();
    // change it back to int
    arr3 = finArr.map(Number);
    
    console.log(arr3);
    

    return arr3;
};


addTwoNumbers([2,4,3], [5,6,4])