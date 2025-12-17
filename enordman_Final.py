# Import the packages
import customtkinter as ctk
import mysql.connector
import matplotlib.pyplot as plt

USERNAME = "enordman"

# Connect to the database
connection = mysql.connector.connect(
    host='128.198.162.191',
    database='finaldb',
    user='finalUser',
    password='itsover!'
)
cursor = connection.cursor()

# Create the tables if they don't exist
cursor.execute(f"""
CREATE TABLE IF NOT EXISTS {USERNAME}_products (
    productID INT PRIMARY KEY AUTO_INCREMENT,
    productName VARCHAR(45),
    productPrice DECIMAL(8,2)
)               
""")  

cursor.execute(f"""
CREATE TABLE IF NOT EXISTS {USERNAME}_sales (
    PK INT PRIMARY KEY AUTO_INCREMENT,
    productID INT,
    unitSales INT,
    salesDate DATE
)
""")
connection.commit()

# Create window
window = ctk.CTk()
window.title("Sales Management System")
window.geometry("500x400")

# Create input fields 
ctk.CTkLabel(window, text="Product Name:").grid(row=0, column=0, padx=10, pady=10)
product_name_entry = ctk.CTkEntry(window, width=200)
product_name_entry.grid(row=0, column=1, padx=10, pady=10)

ctk.CTkLabel(window, text="Product Price:").grid(row=1, column=0, padx=10, pady=10)
product_price_entry = ctk.CTkEntry(window, width=200)
product_price_entry.grid(row=1, column=1, padx=10, pady=10)

ctk.CTkLabel(window, text="Units Sold:").grid(row=2, column=0, padx=10, pady=10)
units_sold_entry = ctk.CTkEntry(window, width=200)
units_sold_entry.grid(row=2, column=1, padx=10, pady=10)

ctk.CTkLabel(window, text="Sales Date (MM-DD-YYYY):").grid(row=3, column=0, padx=10, pady=10)
sales_date_entry = ctk.CTkEntry(window, width=200)
sales_date_entry.grid(row=3, column=1, padx=10, pady=10)

def parse_date(date_string):
    return date_string

# Save the sale to the database
def save_sale():
    product_name = product_name_entry.get()
    product_price = product_price_entry.get()
    units_sold = units_sold_entry.get()
    sales_date = sales_date_entry.get()
    
    if not product_name or not product_price or not units_sold or not sales_date:
        return
    
    try:
        price = float(product_price)
        units = int(units_sold)
        date_str = parse_date(sales_date)
        
        if not date_str:
            return
        
        # Check if the product exists
        cursor.execute(f"SELECT productID FROM {USERNAME}_products WHERE productName = %s AND productPrice = %s",
                       (product_name, price))
        result = cursor.fetchone()
        
        if result:
            product_id = result[0]
        else:
            cursor.execute(f"INSERT INTO {USERNAME}_products (productName, productPrice) VALUES (%s, %s)",
                           (product_name, price))
            product_id = cursor.lastrowid
        
        # Insert Sale
        cursor.execute(f"INSERT INTO {USERNAME}_sales (productID, unitSales, salesDate) VALUES (%s, %s, %s)",
                       (product_id, units, date_str))
        connection.commit()
        
        # Clear fields
        product_name_entry.delete(0, 'end')
        product_price_entry.delete(0, 'end')
        units_sold_entry.delete(0, 'end')
        sales_date_entry.delete(0, 'end')
        
    except:
        pass

def show_sales_graph():
    # Display the bar graph
    try:
        cursor.execute(f"""
        SELECT p.productName, SUM(p.productPrice * s.unitSales) as totalSales
        FROM {USERNAME}_products p
        JOIN {USERNAME}_sales s ON p.productID = s.productID
        GROUP BY p.productName
        ORDER BY p.productName
        """)
        
        results = cursor.fetchall()
        
        if not results:
            return
        
        product_names = [row[0] for row in results]
        total_sales = [float(row[1]) for row in results]
        
        # Create Graph
        plt.figure(figsize=(8, 5))
        plt.bar(product_names, total_sales, color='steelblue')
        plt.xlabel('Product Name')
        plt.ylabel('Total Sales Revenue ($)')
        plt.title('Total Sales by Product')
        plt.xticks(rotation=45)
        plt.tight_layout()
        plt.show()
        
    except:
        pass

# Create Buttons
ctk.CTkButton(window, text="Save Sale", command=save_sale, width=200).grid(row=4, column=0, padx=10, pady=20)
ctk.CTkButton(window, text="Show Sales Graph", command=show_sales_graph, width=200).grid(row=4, column=1, padx=10, pady=20)

window.mainloop()
connection.close()