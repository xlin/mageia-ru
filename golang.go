package main

import (
        "fmt"
        "math"
        "net/http"
)
var x1g,x2g float64
func duble_uravnenie (a, b, c float64) (x1, x2 float64){
    var d,kor float64
        d = b*b - 4*a*c
        if d > 0 {
            kor = math.Sqrt(d)
            x1 = (-b+kor)/2
            x2 = (-b-kor)/2
        }
        x1g, x2g = x1, x2
        return  x1, x2
}
func handler(w http.ResponseWriter, r *http.Request) {
    fmt.Fprintf(w, "\tx1=%f\n\tx2=%f",x1g,x2g)
}

func main() {
    duble_uravnenie(1,10,-3)
    http.HandleFunc("/", handler)
    http.ListenAndServe(":8080", nil)
}
