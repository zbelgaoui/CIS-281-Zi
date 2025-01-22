/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Main.java to edit this template
 */
package javaapplication1;
import java.util.Scanner;


public class JavaApplication1 {


    public static void main(String[] args) {
        Scanner zineb=new Scanner(System.in);
        int Hours;
        double PayRate;
        
        System.out.print("Enter The Hours as an Integer ==>");
        Hours=zineb.nextInt();
        
        System.out.print("Enter The PayRate as a Decimal ==>");
        PayRate=zineb.nextDouble();
         
      
        System.out.println("your Payment is ==>"+CalcPay(Hours, PayRate));
        if(Hours>40)
        {
           System.out.println("You are working overtime!!!");
        } 
        else
        {
            System.out.println("Thanks for using this App!!!");
        }
   
    }
    
    
     static double CalcPay(int h, double pr)
       
    {
     if (h>40)
     {
         return (40*pr)+((h-40)*(pr*1.5));
     }
     else 
     {
         return h*pr;
     }
    }
     
     
}
