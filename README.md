This project is for completing a codetest for Kitomba.

**Project explaination**

Project objective is to find a solution for applying Sales Tax and Import Tax to items in a shopping cart and printing out a receipt with taxes included to each item and a total sales tax added and the total price to be paid. This project has a bunch classes that work together to produce the output. These classes are:
Product.php - abstract class where all "products" will be based on.
            - contains the functions to compute net price, compute total taxes to be paid, get description, check if product is imported, and validate variables passed to constructor.
            
BasicProduct.php - product that is not excempt from sales tax. Subclass       of Product.php.

SalexTaxExcemptProduct.php - product that is excempted from sales tax. Also a subclass of Product.php.

ProductFactory.php - simply creates Products from an array of items  passed. 
                   - Array should be in the form: array('description'=>'xxx xxx','price'=>123.00,'quantity'=>1) NOTE: if quantity is not set, it is assumed to be 1.

Receipt.php - this prints out a receipt in the proper format based on an input of array of "Products".

**RUNNING THE PROGRAM:**

NOTE: Composer dependency manager is needed for this project as we use its autoloader for loading needed classes.
To run the program, simply download the repository to your localhost.

Once project is downloaded, simply run "composer install" from project directory to tell composer to get dependent libraries for this project.

After composer finishes downloading needed libraries, you can just call "php src/index.php" on subject directory commandline to get output.

You can also run UnitTest to see tests and compare it against expected output from test data

To run unit tests simply call "phpunit --bootstrap vendor/autoload.php --testdox Tests" from the root directory of the project.

**Assumptions in the project**

This project assumes that there is a UI frontend to get user shopping cart items and parse it to an array (Array structure is described on top under ProductFactory description). This array is then passed on to a factory (ProductFactory.php) to create "Product" Objects. Output of "ProductFactory" is an array of "Products" and this is then passed on to "Receipt" object and then processes objects to output receipt once "printReceipt" method is called on Receipt object. 

ProductFactory class also assumes that getting product information (isImported,isSalesTaxExcempt) can only be gathered from description of products. Therefore ProductFactory has a whitelist of products "keywords" to excempt from sales tax based on their description. This was assumed since the input test data makes no mention of how to identify product types. Also it is assumed that the only way to know if product is imported is if its description has the word "imported" on them. Anything without that word is considered locally produced product. 

  