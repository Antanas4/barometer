# Use official Node.js image as the base image
FROM node:18 AS frontend

# Set the working directory
WORKDIR /app

# Copy the package.json and package-lock.json (if available) from the parent directory
COPY ../package*.json ./

# Install dependencies
RUN npm install

# Copy the rest of the app's files from the parent directory
COPY ../ ./ 

# Expose the port for React's development server (adjust if using production)
EXPOSE 3000

# Command to run the React app
CMD ["npm", "run", "dev"]
