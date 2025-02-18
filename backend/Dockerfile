# Use an official PHP image with Apache
FROM php:8.1-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy application files into the container
COPY . /var/www/html/

# Expose port 80 for web access
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
