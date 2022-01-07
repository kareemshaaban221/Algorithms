#include <stdio.h>


void print(int* arr, const int len){
    for(int i = 0; i < len; i++){
        printf("%i ", arr[i]);
    }
    printf("\n");
}

int max(int* arr, const int len){
    int max = 0;
    for(int i = 1; i < len; i++){
        if(arr[i] > arr[max]) max = i;
    }
    return max;
}

void countSort(int* arr, const int len, const int k){
    int c[k], b[len];
    for(int i = 0; i < k; i++){ // init array c
        c[i] = 0;
    }
    for(int i = 0; i < len; i++){ // count no distinct elems
        c[arr[i]]++;
    }
    for(int i = 1; i < k; i++){ // prefix sum to get indeces of elems in array b
        c[i] += c[i - 1];
    }
    for(int i = len - 1; i >= 0; i--){ // fill array b
        b[c[arr[i]] - 1] = arr[i];
        c[arr[i]]--;
    }
    for(int i = 0; i < len; i++){ // copy the result
        arr[i] = b[i];
    }
}

void radixSort(int* arr, const int len){ // O(n + k + d) ~ O(n)
    const int k = 10; // num of digit possible values 0-9
    int temp = arr[max(arr, len)]; // get maximum value index of the arr
    int n = 0;
    while(temp > 0){ // counting the number of digits of the first elem in arr
        temp /= 10;
        n++;
    }
    int i = n;
    int c[k]; // counting arr
    while(i--){ // repeat the counting sort based on the number of digits of elements in arr
        int b[len]; // result arr
        int currDigit = n - i;
        int w = 1;
        while(currDigit--) w *= 10; // the weight of the current sorting digit
        for(int j = 0; j < k; j++){ // init c
            c[j] = 0;
        }

        // count based on the current sorting digit
        // for example: w = 10 then tar = the least significant digit of the number
        //              w = 100 then tar = the second least significant digit ...
        for(int j = 0, tar; j < len; j++){
            tar = ((arr[j] % w) / (double)w) * 10;
            c[tar]++;
        }

        for(int j = 1; j < k; j++){ // perform prefix sum on c
            c[j] += c[j - 1];
        }
        for(int j = len - 1, tar; j >= 0; j--){ // fill b with sorted array
            tar = ((arr[j] % w) / (double)w) * 10;
            b[c[tar] - 1] = arr[j];
            c[tar]--;
        }
        for(int j = 0; j < len; j++){ // copy b to arr to be sorted
            arr[j] = b[j];
        }
    }
}

int main(){
    int arr[8] = {77, 530, 68, 31, 42, 49, 20, 10};
    int len = sizeof(arr) / sizeof(arr[0]);
    // print(arr, len);
    radixSort(arr, len);
    print(arr, len);
    return  0;
}