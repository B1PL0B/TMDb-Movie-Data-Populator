**TMDb Movie Data Populator**

**A lightweight WordPress plugin that seamlessly integrates movie data from TMDb into your website's custom fields.**

**Features**

- Adds custom fields to any WordPress theme.
- Fills custom fields with movie data from TMDb (Title, Poster, Release Date, Overview, etc.).
- Easy to install and use.
- Lightweight and efficient.

**Custom Fields**

- **Movie Name**
- **Release Date**
- **Genre**
- **Country of Origin**
- **Movie Poster**
- **Movie Backdrop**
- **Language**
- **Duration**
- **Director Name**
- **Actors Name**
- **Revenue**
- **Budget**
- **Rating**
- **Synopsys**

**Displaying Custom Field Data in Your Post**

**Note:** To display the custom field data populated by the plugin on your post, you can add the `short-code.php`'s code to your theme's `single.php` file. You can modify this code as needed to customize the layout and presentation:

**Usage**

1. **Create Content:** Create a new post or page where you want to display movie data.
2. **Add Custom Fields:** Use the custom fields provided by the plugin to add movie-related information (e.g., movie title, poster image, release date).
3. **Enter TMDb ID:** In the "TMDb ID" custom field, enter the unique identifier of the movie you want to fetch data for.
4. **Save and View:** Save your content and view it on your website. The plugin will automatically fetch and populate the custom fields with corresponding movie data from TMDb.

**Workflow**

1. **User enters TMDb ID:** The user enters a TMDb ID in the designated custom field.
2. **Plugin fetches data:** The plugin sends an API request to TMDb using the provided ID to retrieve movie data.
3. **Custom fields populated:** The plugin automatically populates the corresponding custom fields with the fetched data.
4. **Post data saved:** The updated post data (with populated custom fields) is saved to the WordPress database.

**Contributing**

We welcome contributions to this project. If you'd like to contribute, please fork the repository, make your changes, and submit a pull request.

**License**

This plugin is released under the [MIT License](https://opensource.org/licenses/MIT).

**Additional Notes**

- Ensure you have a valid TMDb API key before using the plugin.
- If you encounter any issues or have suggestions, please feel free to open an issue on this GitHub repository.


