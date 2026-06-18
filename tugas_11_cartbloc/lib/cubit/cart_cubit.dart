import 'package:flutter_bloc/flutter_bloc.dart';
import '../models/product.dart';

class CartCubit extends Cubit<List<Product>> {
  CartCubit() : super([]);

  void addToCart(Product product) {
    final updatedCart = List<Product>.from(state)..add(product);
    emit(updatedCart);
  }

  void removeFromCart(Product product) {
    final updatedCart = List<Product>.from(state)..remove(product);
    emit(updatedCart);
  }
}
