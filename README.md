# Translation Rating System

A web application for managing translations and their ratings, built with PHP and JavaScript.

## Overview

This project is a translation management system that allows users to create translations and receive ratings from other users. The system calculates average ratings for users based on the ratings their translations receive.

## Features

- User management and authentication
- Translation creation and management
- Rating system for translations
- Average rating calculation for users
- RESTful API endpoints
- Web interface for user interactions

## Tech Stack

**Backend:**
- PHP (Laravel/PHP framework)
- SQL database
- Composer for dependency management

**Frontend:**
- JavaScript
- NPM for package management

## Project Structure

The application follows standard MVC architecture with:
- Models for User, Translation, and Rating entities
- Controllers for handling HTTP requests
- Database migrations and seeders
- Feature and unit tests using Pest testing framework

## Key Functionality

### Rating System
- Users can rate translations created by other users
- Average ratings are calculated based on all ratings received by a user's translations
- The system safely handles edge cases like users with no translations or translations with no ratings

### Models
- **User**: Manages user accounts and calculates average ratings
- **Translation**: Stores translation data linked to users
- **Rating**: Stores rating values for specific translations

## Testing

The project includes comprehensive test coverage using Pest testing framework, covering:
- Happy path scenarios
- Edge cases (no translations, no ratings)
- Data integrity and isolation
- Calculation accuracy

## Database Schema

The system uses relational database structure with proper foreign key relationships between users, translations, and ratings to ensure data integrity.
